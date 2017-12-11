<?php

App::uses('AppController', 'Controller');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class IndexController extends AppController {

    /**
     * This controller does not use a model
     *
     * @var array
     */
    public $uses = array();
    public $components = array();

    // Configuración

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow();
    }

    /**
     * render view index / login
     */
    public function home() {
        if (!$this->Auth->login()) {
            $this->layout = 'home_site';
            $this->render('home');
        } else {
            return $this->redirect(Router::url('/', true));
        }
    }

    public function promotions() {
        $this->layout = 'home_site';
        $this->render('promotions');
    }

    public function aboutus() {
        $this->layout = 'home_site';
        $this->render('aboutus');
    }

    public function mobile() {
        $this->layout = 'home_site';
        $this->render('mobile');
    }

    public function poker() {
        $this->layout = 'home_site';
        $this->render('poker');
    }

    public function contact() {
        $this->layout = 'home_site';
        $this->render('contact');
    }

    public function faqs() {
        $this->layout = 'home_site';
        $this->render('faqs');
    }

    public function affiliates() {
        $this->layout = 'home_site';
        $this->render('affiliates');
    }

    public function bigparlay() {
        $this->layout = 'home_site';
        $this->render('bigparlay');
    }

    public function cashier() {
        $this->layout = 'home_site';
        $this->render('cashier');
    }

    public function livebetting() {
        $this->layout = 'home_site';
        $this->render('livebetting');
    }

    public function livecasino() {
        $this->layout = 'home_site';
        $this->render('livecasino');
    }

    public function general() {
        $this->layout = 'home_site';
        $this->render('general');
    }

    public function privacy() {
        $this->layout = 'home_site';
        $this->render('privacy');
    }

    public function responsiblegaming() {
        $this->layout = 'home_site';
        $this->render('responsiblegaming');
    }

    public function slots() {
        $this->layout = 'home_site';
        $this->render('slots');
    }

    public function vegas() {
        $this->layout = 'home_site';
        $this->render('vegas');
    }

    public function vip() {
        $this->layout = 'home_site';
        $this->render('vip');
    }

    public function winneroftheday() {
        $this->layout = 'home_site';
        $this->render('winneroftheday');
    }

    /**
     * render view index / register
     */
    public function register() {
        $this->layout = 'home_site';
        $this->render('register');
    }

    /**
     * render view index / register
     */
    public function terms() {
        $this->layout = 'home_site';
        $this->render('terms');
    }

    /**
     * render view index / race
     */
    public function race() {
        $this->layout = 'home_site';
        $this->render('race');
    }

    /**
     * render view index / race
     */
    public function sports() {
        $this->layout = 'home_site';
        $this->render('sports');
    }

    /**
     * render view index / race
     */
    public function live() {
        $this->layout = 'home_site';
        $this->render('live');
    }

    /**
     * render view index / race
     */
    public function casino() {
        $this->layout = 'home_site';
        $this->render('casino');
    }

}
