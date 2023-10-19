<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Goutte\Client;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
class ScrapData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scrap:data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $client = new Client();
        $guzzleClient = new \GuzzleHttp\Client(array(
            'curl' => array(
                CURLOPT_TIMEOUT => 60,
            ),
            'verify' => false
          ));
      
        $client->setClient($guzzleClient);
        $website = $client->request('GET', 'https://kursdollar.org');

        $get_td_values = $website->filter('.in_table')->filter('tr')->each(function ($tr) {
            return $tr->filter('td')->each(function ($td, $i) {
                return $td->text();
            });
        });

        $total_get_td = 23;
        $save_to_storage = [];
        $index_of_rate = 0;
        
        for ($i=0; $i < $total_get_td; $i++) { 
            $td = 1;
            foreach ($get_td_values[$i] as $key => $value) {
                if ($value != '') {
                    if($i == 1) { // set meta
                        $save_to_storage['meta']['date'] = date('d-m-Y');
                        $save_to_storage['meta']['day'] = date("l");
                        if ($td == 2) {
                            $save_to_storage['meta']['indonesia'] = $value;
                        } elseif ($td == 3) {
                            $save_to_storage['meta']['word'] = $value;
                        }
                    } else if ($i > 2) {
                        if ($td == 1) {
                            $save_to_storage['rates'][$index_of_rate]['currency'] = $value;
                        } elseif ($td == 2) {
                            $arr_value = explode(" ",$value);
                            $save_to_storage['rates'][$index_of_rate]['buy'] = $arr_value[0];
                        } elseif ($td == 3) {
                            $arr_value = explode(" ",$value);
                            $save_to_storage['rates'][$index_of_rate]['sell'] = $arr_value[0];
                        } elseif ($td == 4) {
                            $arr_value = explode(" ",$value);
                            $save_to_storage['rates'][$index_of_rate]['average'] = $arr_value[0];
                        } elseif ($td == 5) {
                            $save_to_storage['rates'][$index_of_rate]['word_rate'] = $value;
                        }
                    }
                    $td++;
                } 
            }
            if ($i > 2) {
                $index_of_rate++;
            }
        }
        $json = json_encode($save_to_storage);
        $this->info($json);
        if (! File::exists(storage_path('rate'))) {
            File::makeDirectory(storage_path('rate'), 0777, true);
        }
        file_put_contents(storage_path('rate') . '/' . "rate-" . date('d-m-Y-H-i-s') . ".json" , $json, FILE_APPEND);
        
        $this->info("Cron is working fine!" );
    }
}
