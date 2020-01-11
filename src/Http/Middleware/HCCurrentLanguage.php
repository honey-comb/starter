<?php

declare(strict_types = 1);

namespace HoneyComb\Starter\Http\Middleware;

use Closure;
use HoneyComb\Starter\Services\HCLanguageService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

/**
 * Class HCCurrentLanguage
 * @package HoneyComb\Starter\Http\Middleware
 */
class HCCurrentLanguage
{
    /**
     * @var HCLanguageService
     */
    private $languageService;

    /**
     * HCCheckSelectedAdminLanguage constructor.
     * @param HCLanguageService $languageService
     */
    public function __construct(HCLanguageService $languageService)
    {
        $this->languageService = $languageService;
    }

    /**
     * @param Request $request
     * @param Closure $next
     * @return mixed
     * @throws \Exception
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->headers->has(config('starter.header_interface_language_key'))) {
            /** @var Collection $enabled */
            $enabled = $this->languageService->getInterfaceActiveLanguages();

            $locale = $request->headers->get(config('starter.header_interface_language_key'));

            if (!$enabled->contains('iso_639_1', $locale)) {
                $locale = config('app.locale');
            }

            app()->setLocale($locale);
        }

        return $next($request);
    }
}
