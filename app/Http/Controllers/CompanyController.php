<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Review;
use App\Services\YandexMapsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class CompanyController extends Controller
{
    protected YandexMapsService $yandexMapsService;

    public function __construct(YandexMapsService $yandexMapsService)
    {
        $this->yandexMapsService = $yandexMapsService;
    }

    public function settings()
    {
        return Inertia::render('Company/Settings', [
            'company' => Auth::user()->company,
        ]);
    }

    public function saveUrl(Request $request)
    {
        $request->validate(['yandex_url' => 'required|url']);

        $user = Auth::user();
        $company = $user->company ?? new Company(['user_id' => $user->id]);
        $company->yandex_url = $request->yandex_url;
        $company->save();

        $this->fetchReviews($company);

        return redirect()->route('company.reviews');
    }

    public function reviews()
    {
        $company = Auth::user()->company;

        if (!$company) {
            return redirect()->route('company.settings');
        }

        return Inertia::render('Company/Reviews', [
            'company' => $company,
            'reviews' => $company->reviews()->orderBy('review_date', 'desc')->get(),
        ]);
    }

    public function refreshReviews()
    {
        $company = Auth::user()->company;

        if (!$company) {
            return response()->json(['error' => 'Company not found'], 404);
        }

        $this->fetchReviews($company);

        return response()->json([
            'company' => $company->fresh(),
            'reviews' => $company->reviews()->orderBy('review_date', 'desc')->get(),
        ]);
    }

    private function fetchReviews(Company $company)
    {
        $organizationId = $this->yandexMapsService->extractOrganizationId($company->yandex_url);

        if (!$organizationId) {
            return;
        }

        $data = $this->yandexMapsService->getOrganizationData($organizationId);

        if ($data) {
            $company->update([
                'rating' => $data['rating'],
                'reviews_count' => $data['reviews_count'],
            ]);

            $company->reviews()->delete();

            foreach ($data['reviews'] as $reviewData) {
                Review::create([
                    'company_id' => $company->id,
                    'author_name' => $reviewData['author_name'],
                    'text' => $reviewData['text'],
                    'rating' => $reviewData['rating'],
                    'review_date' => $reviewData['date'],
                ]);
            }
        }
    }
}
