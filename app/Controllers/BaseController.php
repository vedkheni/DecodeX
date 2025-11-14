<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Libraries\Allfunction;
use App\Libraries\Salarypayfunction;
use App\Libraries\Mailfunction;
use App\Libraries\Lib;
use App\Libraries\Mpdfgenerator;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $helpers = ['form','url','date','number','cookie','filesystem'];
	protected $uri;
	protected $request;
	protected $session;
	protected $security;
	protected $form_validation;
	protected $allfunction;
	protected $salarypayfunction;
	protected $mailfunction;
	protected $mpdfgenerator;
	protected $lib;
	protected $Candidate_Model;
	protected $Holiday_Model;
	protected $Designation_Model;
	protected $Pc_Issue_Model;
	protected $Administrator_Model;
	protected $Dashboard_Model;
	protected $Deposit_Payment_Model;
	protected $Deposit_Report_Model;
	protected $Deposit_Model;
	protected $Leave_Report_Model;
	protected $Leave_Request_Model;
	protected $Reports_Model;
	protected $Employee_Model;
	protected $Salary_Pay_Model;
	protected $Bonus_Model;
	protected $Employee_Increment_Model;
	protected $Increment_Model;
	protected $Internship_Model;
	protected $Employee_Attendance_Model;
	protected $Mail_Content_Model;
	protected $Paid_Leave_Model;
	protected $Prof_Tax_Model;
	protected $login_Model;
	protected $Terms_Condition_Model;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var list<string>
     */
    // protected $helpers = [];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

    /**
     * @return void
     */
    function __construct()
    {
		date_default_timezone_set("Asia/Kolkata");
        $this->session = \Config\Services::session();
        $this->session->start();
		$user_session=$this->session->get('id');
		if(empty($user_session)){
			return redirect()->to(base_url());
		}
    }
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);
		$security = \Config\Services::security();
		$this->uri = service('uri');
		$this->request = \Config\Services::request();
		$this->allfunction = new Allfunction();
		$this->salarypayfunction = new Salarypayfunction();
		$this->mailfunction = new Mailfunction();
		$this->mpdfgenerator = new Mpdfgenerator();
		$this->lib = new Lib();
		$this->form_validation =  \Config\Services::validation();
		$this->Candidate_Model = new \App\Models\Candidate_Model();
		$this->Holiday_Model = new \App\Models\Holiday_Model();
		$this->Administrator_Model = new \App\Models\Administrator_Model();
		$this->Designation_Model = new \App\Models\Designation_Model();
		$this->Deposit_Payment_Model = new \App\Models\Deposit_Payment_Model();
		$this->Deposit_Report_Model = new \App\Models\Deposit_Report_Model();
		$this->Deposit_Model = new \App\Models\Deposit_Model();
		$this->Pc_Issue_Model = new \App\Models\Pc_Issue_Model();
		$this->Dashboard_Model = new \App\Models\Dashboard_Model();
		$this->Leave_Report_Model = new \App\Models\Leave_Report_Model();
		$this->Leave_Request_Model = new \App\Models\Leave_Request_Model();
		$this->Reports_Model = new \App\Models\Reports_Model();
		$this->Employee_Model = new \App\Models\Employee_Model();
		$this->Salary_Pay_Model = new \App\Models\Salary_Pay_Model();
		$this->Bonus_Model = new \App\Models\Bonus_Model();
		$this->Employee_Increment_Model = new \App\Models\Employee_Increment_Model();
		$this->Increment_Model = new \App\Models\Increment_Model();
		$this->Internship_Model = new \App\Models\Internship_Model();
		$this->Employee_Attendance_Model = new \App\Models\Employee_Attendance_Model();
		$this->Mail_Content_Model = new \App\Models\Mail_Content_Model();
		$this->Paid_Leave_Model = new \App\Models\Paid_Leave_Model();
		$this->Prof_Tax_Model = new \App\Models\Prof_Tax_Model();
		$this->login_Model = new \App\Models\Login_Model();
		$this->Terms_Condition_Model = new \App\Models\Terms_Condition_Model();
		$this->Broadcast_Model = new \App\Models\Broadcast_Model();
		$this->db = \Config\Database::connect();

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = \Config\Services::session();
    }
}
