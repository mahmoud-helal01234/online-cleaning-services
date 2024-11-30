<?php

namespace App\Jobs;

use App\Models\SiteVisit;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class ProcessSiteVisitJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $ip;
    protected $userAgent;

    /**
     * Create a new job instance.
     *
     * @param string $ip
     * @param string $userAgent
     */
    public function __construct($ip, $userAgent)
    {
        $this->ip = $ip;
        $this->userAgent = $userAgent;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        Log::info('Starting the tracking visitors job...');

        try {
 
            $locationDetails = file_get_contents("http://www.geoplugin.net/json.gp?ip={$this->ip}");
            $details = json_decode($locationDetails, true);

            $city = $details['geoplugin_city'] ?? 'Unknown';
            $region = $details['geoplugin_region'] ?? 'Unknown';

            $country = $details['geoplugin_countryName'] ?? 'Unknown';
            $lat = $details['geoplugin_latitude'] ?? 'Unknown';
            $long = $details['geoplugin_longitude'] ?? 'Unknown';

            // Detect user agent
            $browser = 'Unknown';
            $platform = 'Unknown';

            // Optional: Use jenssegers/agent for detailed browser and platform detection
            if (class_exists('Jenssegers\Agent\Agent')) {
                $agent = new \Jenssegers\Agent\Agent();
                $browser = $agent->browser();
                $platform = $agent->platform();
            }

            // Insert into the database
            SiteVisit::create([
                'ip_address' => $this->ip,
                'city' => $city,
                'region' => $region,
                'country' => $country,
                'browser' => $browser,
                'platform' => $platform,
                'latitude' => $lat,
                'longitude' => $long
            ]);
        } catch (\Exception $e) {
            // Log error but don't disrupt user experience
            Log::error('Failed to log site visit: ' . $e->getMessage());
        }


    }

}
