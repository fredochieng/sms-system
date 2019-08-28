<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Carbon\Carbon;
use DB;

class UpdateSummaryReportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    private $date;

    public function __construct($date = null)
    {
        if ($date == null) {
            $date = Carbon::now();
        }
        $this->date = $date;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $year = $this->date->year;
        $month = $this->date->month;
        // $date = '2019-07-13';
        $today = $this->date->toDateString();
        // $today = '2019-07-15';
        $start_date = $this->date->startOfMonth()->toDateString();

        $report_data = DB::table('quees')
            ->select(
                DB::raw('quees.created_at as que_date'),
                DB::raw('quees.status'),
                DB::raw('texts.recepient_country_id as country_id'),
                DB::raw('texts.user_department_id as sender_dept_id'),
                DB::raw('COUNT(quees.text_id) AS all_texts'),
                DB::raw('COUNT(CASE WHEN quees.status = 2 THEN 1 END) AS sent_texts'),
                DB::raw('COUNT(CASE WHEN quees.status = 1 THEN 1 END) AS queed_texts'),
                DB::raw('COUNT(CASE WHEN quees.status = 2 THEN 1 END) AS delivered_texts'),
                DB::raw('COUNT(CASE WHEN quees.status = 3 THEN 1 END) AS failed_texts')
            )
            ->Join('texts', 'quees.text_id', '=', 'texts.text_id')
            ->Join('users', 'texts.created_by', '=', 'users.id')
            ->Join('recipients_country', 'texts.recepient_country_id', '=', 'recipients_country.recipients_country_id')
            ->whereRaw("CAST(texts.created_at as DATE) = '" . $today . "'")
            ->where('texts.user_department_id', '<>', null)
            ->groupBy('texts.recepient_country_id')
            ->groupBy('texts.user_department_id')
            ->get();

        foreach ($report_data as $key => $value) {

            $daily_report = DB::table('summary_report')
                ->select(
                    DB::raw('date'),
                    DB::raw('country_id'),
                    DB::raw('dept_id'),
                    DB::raw('sum(sent) as sent'),
                    DB::raw('sum(delivered) as delivered'),
                    DB::raw('sum(failed) as failed'),
                    DB::raw('sum(pending) as pending')
                )
                ->whereBetween('date', array($start_date, $today))
                ->groupBy('country_id', 'dept_id')
                ->get();

            // echo "<pre>";
            // print_r($daily_report);
            // exit;

            DB::table('summary_report')->upsert(
                [
                    'date' => $today, 'country_id' => $value->country_id, 'dept_id' => $value->sender_dept_id, 'sent' => $value->sent_texts,
                    'delivered' => $value->delivered_texts, 'failed' => $value->failed_texts, 'pending' => $value->queed_texts
                ],
                ['date', 'country_id', 'dept_id'],
                ['sent', 'delivered', 'failed', 'pending', 'updated_at']
            );

            // $summary_array = array(
            // 	'date' => $today, 'country_id' => $value->country_id, 'dept_id' => $value->sender_dept_id, 'sent' => $value->sent_texts,
            // 	'delivered' => $value->delivered_texts, 'failed' => $value->failed_texts, 'pending' => $value->queed_texts
            // );

            // $save_mont hly_summary_report = DB::table('summary_report')->upsert($summary_array),

            // ;
        }

        $monthly_report = DB::table('summary_report')
            ->select(
                DB::raw('sum(sent) as sent'),
                DB::raw('sum(delivered) as delivered'),
                DB::raw('sum(failed) as failed'),
                DB::raw('sum(pending) as pending'),
                DB::raw('country_id'),
                DB::raw('dept_id')
            )
            ->whereBetween('date', array($start_date, $today))
            ->groupBy('country_id', 'dept_id')
            ->get();

        foreach ($monthly_report as $key => $monthly) {

            // $monthly_summary_array = array(
            // 	'date' => $today, 'year' => $year, 'month' => $month, 'country_id' => $monthly->country_id, 'dept_id' => $monthly->dept_id, 'sent' => $monthly->sent,
            // 	'delivered' => $monthly->delivered, 'failed' => $monthly->failed, 'pending' => $monthly->pending
            // );
            // $save_monthly_summary_report = DB::table('monthly_summary_report')->insertGetId($monthly_summary_array);

            DB::table('monthly_summary_report')->upsert(
                [
                    'date' => $today, 'year' => $year, 'month' => $month, 'country_id' => $monthly->country_id, 'dept_id' => $monthly->dept_id, 'sent' => $monthly->sent,
                    'delivered' => $monthly->delivered, 'failed' => $monthly->failed, 'pending' => $monthly->pending
                ],
                ['date', 'country_id', 'dept_id'],
                ['sent', 'delivered', 'failed', 'pending', 'updated_at']
            );
        }
    }
}