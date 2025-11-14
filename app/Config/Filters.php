<?php

namespace Config;

use CodeIgniter\Config\Filters as BaseFilters;
use CodeIgniter\Filters\Cors;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\ForceHTTPS;
use CodeIgniter\Filters\Honeypot;
use CodeIgniter\Filters\InvalidChars;
use CodeIgniter\Filters\PageCache;
use CodeIgniter\Filters\PerformanceMetrics;
use CodeIgniter\Filters\SecureHeaders;

class Filters extends BaseFilters
{
    /**
     * Configures aliases for Filter classes to
     * make reading things nicer and simpler.
     *
     * @var array<string, class-string|list<class-string>>
     *
     * [filter_name => classname]
     * or [filter_name => [classname1, classname2, ...]]
     */
    public array $aliases = [
        'csrf'          => CSRF::class,
        'toolbar'       => DebugToolbar::class,
        'honeypot'      => Honeypot::class,
        'invalidchars'  => InvalidChars::class,
        'secureheaders' => SecureHeaders::class,
        'cors'          => Cors::class,
        'forcehttps'    => ForceHTTPS::class,
        'pagecache'     => PageCache::class,
        'performance'   => PerformanceMetrics::class,
    ];

    /**
     * List of special required filters.
     *
     * The filters listed here are special. They are applied before and after
     * other kinds of filters, and always applied even if a route does not exist.
     *
     * Filters set by default provide framework functionality. If removed,
     * those functions will no longer work.
     *
     * @see https://codeigniter.com/user_guide/incoming/filters.html#provided-filters
     *
     * @var array{before: list<string>, after: list<string>}
     */
    public array $required = [
        'before' => [
            'forcehttps', // Force Global Secure Requests
            'pagecache',  // Web Page Caching
        ],
        'after' => [
            'pagecache',   // Web Page Caching
            'performance', // Performance Metrics
            'toolbar',     // Debug Toolbar
        ],
    ];

    /**
     * List of filter aliases that are always
     * applied before and after every request.
     *
     * @var array<string, array<string, array<string, string>>>|array<string, list<string>>
     */
    public array $globals = [
        'before' => [
            // 'honeypot',
            'csrf' => ['except' => ['/salary_pay/remove_deposit','/salary_pay_new/remove_deposit','/salary_pay/pay_deposit','/salary_pay_new/pay_deposit','/employee/add_time','/reports/employee_increment_deatils','/reports/bonus_onchange','/reports/deposit_onchange','/reports/all_salary_details','/reports/total_employee_attendance','/reports/employee_data_new','/reports/employee_data','/reports/employee_pagination','/dashboard/insert_increment_rejected','/terms_and_condition/agree_terms','/terms_and_condition/update_terms','/dashboard/insert_increment','/increment/append_data_employee','/increment/insert_increment','/dashboard/update_increment_status','/reports/current_month_leave','/reports/current_month_deposit','/reports/current_month_prof_tax','/employee/full_month_attendance','/employee/insert_full_attendance','/leave_request/leave_count','/salary_pay','/salary_pay_new','/salary_pay/insert_data','/salary_pay_new/insert_data','/salary_pay/salary_all_details','/salary_pay_new/salary_all_details','/salary_pay_new/salary_pay_all','/salary_pay/[0-9]+/[0-9]+','/salary_pay_new/[0-9]+/[0-9]+','/issues/employee_pagination','/candidates/employee_pagination_search','/issues/employee_pagination_in_progress','/issues/employee_pagination_completed','/issues/update_status','/employee/employee_attendance_list/[0-9]+','/project_task/employee_pagination','/employee/employee_pagination','/employee/update_employee_status','/designation/employee_pagination','/bonus/employee_pagination','/deposit/employee_pagination','/deposit/deposit_employee_data','/deposit/deposit_insert_data','/deposit/insert_data_payment','/deposit/employee_pagination_list/[0-9]+','/increment/update_increment','/increment/employee_pagination_list','/increment/employee_pagination_list/[0-9]+','/leave_request/employee_pagination','/leave_request/employee_pagination/[a-z]+/[0-9]+','/leave_request/update_status','/leave_request/delete_employee','/designation/delete_employee','/project/employee_pagination','/project_task/delete_employee','/employee/delete_employee','/employee/delete_employee_attendance','/employee/insert_data','/project/delete_employee','/profile/insert_data','/employee/insert_employee_attendance','/profile/insert_employee_attendance_new','/salary_slip/calculate_slip','/holiday/get_exists_holiday_date','/reports','/profile/profile_image_change','/holiday/delete_holiday','/bonus/delete_employee','/salary_pay_new/employee_pagination','/salary_pay/employee_pagination','/reports/logs','/reports/prof_tax_pagination','/reports/deposit_pagination','/reports/leaves_pagination','/reports/prof_tax_onchange','/reports/leave_onchange','/reports/paid_leave_onchange1','/reports/paid_leave_onchange','/reports/salary_onchange','/reports/employee_report1','/employee/employee_data_new','/employee/total_employee_attendance','/employee/employee_attendance1','/employee/search_employee_attendance','/reports/sick_leave_onchange','/salary_pay/ajax_bank_status','/salary_pay_new/ajax_bank_status','/deposit/employee_pagination_list','/deposit/total_deposits','/bonus/totle_bouns','/salary_pay/total_salary','/salary_pay_new/total_salary','/employee/employee_data_new1','/leave_request/employee_pagination/pending','/leave_request/employee_pagination/approved','/leave_request/employee_pagination/rejected','/employee/insert_leave_data','/employee/delete_employee_all_leave','/leave_request/get_leave_detail','/leave_request/insert_data','/employee/employee_pagination_search','/designation/insert_data','/designation/add','/profile/emp_salary_detail','/deposit/insert_data','/login/insert_data','/user/profile_detail_change','/holiday/insert_data','/holiday/get_holiday_list','/holiday/delete_data','/leave_request/delete_leave','/reports/attendance_report','/employee/get_employee_detail','/login/js_validation','/admin/js_validation','/paid_leave/paid_leave_list','/paid_leave/update_leave','/paid_leave/delete_leave','/candidates/get_candidates','/candidates/update','/candidates/list_candidates','/candidates/update_hrround_detail','/candidates/update_tcround_detail','/candidates/update_fround_detail','/candidates/delete_candidate','/mail_content/update_content','/mail_content/get_content_list','/mail_content/get_mail_content','/candidates/send_mail','/mail_content/delete_mail_content','/profile/insert_today_task','/profile/getAttendance','/pc_issue/changPC_id','/pc_issue/list_pcIssue','/pc_issue/changeStatus','/pc_issue/delete_pcIssue','/pc_issue/getPC_id','/deposit/getDeposit_data','/deposit/deleteDeposit','/pc_issue/insert_data','/pc_issue/getIssue','/candidates/importdata','/reports/get_workingHours','/employee/detail','/employee/getWork_Updates','/salary_pay/salaryDataInsert','/salary_pay/get_salaryDetails','/paid_leave/paidLeave_byYear','/broadcast/addMessage','/broadcast/getMessageList','/broadcast/getBroadcastMessage','/broadcast/deleteBroadcastMessage','/broadcast/allBroadcastMassage','/dashboard/checkPassword','/dashboard/changePassword','/login/forgotPass','/broadcast/broadcastSendMail','/login/sendForgotPass','/resetPassword/[0-9]+/[a-z,0-9]+','increment/update_increment_status','profile/uploadAgreement','increment/delete_increment','profile/uploadPhoto','reports/employeeWorkUpdates','leave_request/view_leave_reason','internship/insert_intern','internship/intern_list','internship/get_intern_detail','internship/delete_intern']],
            // 'invalidchars',
        ],
        'after' => [
            // 'honeypot',
            // 'secureheaders',
        ],
    ];

    /**
     * List of filter aliases that works on a
     * particular HTTP method (GET, POST, etc.).
     *
     * Example:
     * 'POST' => ['foo', 'bar']
     *
     * If you use this, you should disable auto-routing because auto-routing
     * permits any HTTP method to access a controller. Accessing the controller
     * with a method you don't expect could bypass the filter.
     *
     * @var array<string, list<string>>
     */
    public array $methods = [];

    /**
     * List of filter aliases that should run on any
     * before or after URI patterns.
     *
     * Example:
     * 'isLoggedIn' => ['before' => ['account/*', 'profiles/*']]
     *
     * @var array<string, array<string, list<string>>>
     */
    public array $filters = [];
}
