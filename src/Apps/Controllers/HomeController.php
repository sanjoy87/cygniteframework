<?php
namespace Apps\Controllers;

use Cygnite\Mvc\View\View;
use Cygnite\Foundation\Application;
use Cygnite\Foundation\Http\Response;
use Cygnite\Mvc\Controller\AbstractBaseController;

class HomeController extends AbstractBaseController
{
    /**
    * --------------------------------------------------------------------------
    * The Default Controller
    *--------------------------------------------------------------------------
    *  This controller respond to uri beginning with home and also
    *  respond to root url like "home/index"
    *
    * Your GET request of "home/index" will respond like below -
    *
    *      public function indexAction()
    *     {
    *            echo "Cygnite : Hellow ! World ";
    *     }
    * Note: By default cygnite doesn't allow you to pass query string in url, which
    * consider as bad url format.
    *
    * You can also pass parameters into the function as below-
    * Your request to  "home/form/2134" will pass to
    *
    *      public function formAction($id = ")
    *      {
    *             echo "Cygnite : Your user Id is $id";
    *      }
    * In case if you are not able to access parameters passed into method
    * directly as above, you can also get the uri segment
    *  echo Url::segment(3);
    *
    * That's it you are ready to start your awesome application with Cygnite Framework.
    *
    */

    protected $layout = 'layouts.home';

    protected $templateEngine = false;

   // protected $templateExtension = '.html.twig';

   //protected $autoReload = true;
     /*
     * Your constructor.
     * @access public
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Default method for your controller. Render welcome page to user.
     * @access public
     *
     */
   public function indexAction()
   {
       $content = View::create('Apps.Views.home.welcome', ['title' => 'Welcome to Cygnite Framework']);

       return Response::make($content)->send();
   }
}//End of your home controller
