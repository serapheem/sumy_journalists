<?php
/**
 * Contains class for testing procedure of login and logout to/from Admin panel
 *
 * @author      Serhiy Hlushko <serhiy.hlushko@gmail.com>
 * @copyright   Copyright 2013 Hlushko inc.
 * @company     Hlushko inc.
 */

class AdminLoginCest
{
    /**
     * @param \TestGuy              $I
     * @param \Codeception\Scenario $scenario
     */
    public function shouldRedirectToLoginPage(\TestGuy $I, $scenario)
    {
        $I->wantTo('See redirect to login page');
        $I->amOnPage('/admin');

        $I->seeCurrentUrlEquals('/admin/default/login');
        $I->seeResponseCodeIs(200);
    }

    /**
     * @param \TestGuy              $I
     * @param \Codeception\Scenario $scenario
     */
    public function shouldSeeLoginPage(\TestGuy $I, $scenario)
    {
        $I->wantTo('See Login form to Admin panel');
        $I->amOnPage('/admin/default/login');
        $I->seeResponseCodeIs(200);

        $I->seeElement('#Login_email');
        $I->seeElement('#Login_password');
        $I->seeElement('#Login_rememberMe');
        $I->dontSeeCheckboxIsChecked('#Login_rememberMe');
        $I->seeElement('#btnLogin');
    }

    /**
     * @param \TestGuy              $I
     * @param \Codeception\Scenario $scenario
     */
    public function shouldLoginToAdminPanel(\TestGuy $I, $scenario)
    {
        // TODO : S.H. need to use fixture's data
        $I->wantTo('Check login procedure');
        $I->amOnPage('/admin/default/login');

        $I->submitForm(
            '#admin-wrapper form',
            array('Login' => array('email' => 'serapheem@inbox.ru', 'password' => 'i_46820Y-'))
        );

        $I->seeResponseCodeIs(200);
        $I->seeCurrentUrlEquals('/admin');
    }

    /**
     * @param \TestGuy              $I
     * @param \Codeception\Scenario $scenario
     */
    public function shouldCheckEmptyData(\TestGuy $I, $scenario)
    {
        $I->wantTo('Check work with empty data');
        $I->amOnPage('/admin/default/login');

        $I->submitForm(
            '#admin-wrapper form',
            array('Login' => array('email' => '', 'password' => ''))
        );

        $I->seeResponseCodeIs(200);
        $I->seeCurrentUrlEquals('/admin/default/login');
        $I->seeElement('div.errorSummary');
    }

    /**
     * @param \TestGuy              $I
     * @param \Codeception\Scenario $scenario
     */
    public function shouldCheckEmptyEmail(\TestGuy $I, $scenario)
    {
        $I->wantTo('Check work with empty email');
        $I->amOnPage('/admin/default/login');

        $I->submitForm(
            '#admin-wrapper form',
            array('Login' => array('email' => '', 'password' => 'i_46820Y-'))
        );

        $I->seeResponseCodeIs(200);
        $I->seeCurrentUrlEquals('/admin/default/login');
        $I->seeElement('div.errorSummary');
    }

    /**
     * @param \TestGuy              $I
     * @param \Codeception\Scenario $scenario
     */
    public function shouldCheckEmptyPassword(\TestGuy $I, $scenario)
    {
        $I->wantTo('Check work with empty password');
        $I->amOnPage('/admin/default/login');

        $I->submitForm(
            '#admin-wrapper form',
            array('Login' => array('email' => 'serapheem@inbox.ru', 'password' => ''))
        );

        $I->seeResponseCodeIs(200);
        $I->seeCurrentUrlEquals('/admin/default/login');
        $I->seeElement('div.errorSummary');
    }

    /**
     * @param \TestGuy              $I
     * @param \Codeception\Scenario $scenario
     */
    public function shouldCheckIncorrectCredentials(\TestGuy $I, $scenario)
    {
        $I->wantTo('Check credential checking algorithm');
        $I->amOnPage('/admin/default/login');

        $I->submitForm(
            '#admin-wrapper form',
            array('Login' => array('email' => 'user@wrong.com', 'password' => 'wrong_password'))
        );

        $I->seeResponseCodeIs(200);
        $I->seeCurrentUrlEquals('/admin/default/login');
        $I->seeElement('div.errorSummary');
    }

    /**
     * @param \TestGuy              $I
     * @param \Codeception\Scenario $scenario
     */
    public function shouldSeeSiteSetting(\TestGuy $I, $scenario)
    {
        $I->wantTo('See site setting on first Admin panel page');
        $I->amOnPage('/admin/default/login');
        $I->submitForm(
            '#admin-wrapper form',
            array('Login' => array('email' => 'serapheem@inbox.ru', 'password' => 'i_46820Y-'))
        );
        $I->seeCurrentUrlEquals('/admin');
        $I->seeResponseCodeIs(200);

        $I->seeElement('#settings');
        $I->seeElement('#title');
        $I->seeElement('#description');
        $I->seeElement('#keywords');
        $I->seeElement('#offline');
        $I->seeElement('#offlineText');
        $I->seeElement('#adminEmail');
    }

    /**
     * @param \TestGuy              $I
     * @param \Codeception\Scenario $scenario
     */
    public function shouldLogoutFromAdminPanel(\TestGuy $I, $scenario)
    {
        $I->wantTo('Check logout procedure');
        $I->amOnPage('/admin/default/login');

        $I->submitForm(
            '#admin-wrapper form',
            array('Login' => array('email' => 'serapheem@inbox.ru', 'password' => 'i_46820Y-'))
        );
        $I->seeCurrentUrlEquals('/admin');

        $I->click('a[href=/admin/default/logout]', '#menu');

        $I->seeResponseCodeIs(200);
        $I->seeCurrentUrlEquals('/admin/default/login');
    }

}