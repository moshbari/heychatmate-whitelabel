<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

$controller_path = 'App\Http\Controllers';
$front_path = 'App\Http\Controllers\Front';
$gateway_path = 'App\Http\Controllers\Gateway';

// Main Page Route

// layout
Route::get('/layouts/without-menu', $controller_path . '\layouts\WithoutMenu@index')->name('layouts-without-menu');
Route::get('/layouts/without-navbar', $controller_path . '\layouts\WithoutNavbar@index')->name('layouts-without-navbar');
Route::get('/layouts/fluid', $controller_path . '\layouts\Fluid@index')->name('layouts-fluid');
Route::get('/layouts/container', $controller_path . '\layouts\Container@index')->name('layouts-container');
Route::get('/layouts/blank', $controller_path . '\layouts\Blank@index')->name('layouts-blank');

// pages
Route::get('/pages/account-settings-account', $controller_path . '\pages\AccountSettingsAccount@index')->name('pages-account-settings-account');
Route::get('/pages/account-settings-notifications', $controller_path . '\pages\AccountSettingsNotifications@index')->name('pages-account-settings-notifications');
Route::get('/pages/account-settings-connections', $controller_path . '\pages\AccountSettingsConnections@index')->name('pages-account-settings-connections');
Route::get('/pages/misc-error', $controller_path . '\pages\MiscError@index')->name('pages-misc-error');
Route::get('/pages/misc-under-maintenance', $controller_path . '\pages\MiscUnderMaintenance@index')->name('pages-misc-under-maintenance');

// authentication
Route::get('/auth/login-basic', $controller_path . '\authentications\LoginBasic@index')->name('auth-login-basic');
Route::get('/auth/register-basic', $controller_path . '\authentications\RegisterBasic@index')->name('auth-register-basic');
Route::get('/auth/forgot-password-basic', $controller_path . '\authentications\ForgotPasswordBasic@index')->name('auth-reset-password-basic');

// cards
Route::get('/cards/basic', $controller_path . '\cards\CardBasic@index')->name('cards-basic');

// User Interface
Route::get('/ui/accordion', $controller_path . '\user_interface\Accordion@index')->name('ui-accordion');
Route::get('/ui/alerts', $controller_path . '\user_interface\Alerts@index')->name('ui-alerts');
Route::get('/ui/badges', $controller_path . '\user_interface\Badges@index')->name('ui-badges');
Route::get('/ui/buttons', $controller_path . '\user_interface\Buttons@index')->name('ui-buttons');
Route::get('/ui/carousel', $controller_path . '\user_interface\Carousel@index')->name('ui-carousel');
Route::get('/ui/collapse', $controller_path . '\user_interface\Collapse@index')->name('ui-collapse');
Route::get('/ui/dropdowns', $controller_path . '\user_interface\Dropdowns@index')->name('ui-dropdowns');
Route::get('/ui/footer', $controller_path . '\user_interface\Footer@index')->name('ui-footer');
Route::get('/ui/list-groups', $controller_path . '\user_interface\ListGroups@index')->name('ui-list-groups');
Route::get('/ui/modals', $controller_path . '\user_interface\Modals@index')->name('ui-modals');
Route::get('/ui/navbar', $controller_path . '\user_interface\Navbar@index')->name('ui-navbar');
Route::get('/ui/offcanvas', $controller_path . '\user_interface\Offcanvas@index')->name('ui-offcanvas');
Route::get('/ui/pagination-breadcrumbs', $controller_path . '\user_interface\PaginationBreadcrumbs@index')->name('ui-pagination-breadcrumbs');
Route::get('/ui/progress', $controller_path . '\user_interface\Progress@index')->name('ui-progress');
Route::get('/ui/spinners', $controller_path . '\user_interface\Spinners@index')->name('ui-spinners');
Route::get('/ui/tabs-pills', $controller_path . '\user_interface\TabsPills@index')->name('ui-tabs-pills');
Route::get('/ui/toasts', $controller_path . '\user_interface\Toasts@index')->name('ui-toasts');
Route::get('/ui/tooltips-popovers', $controller_path . '\user_interface\TooltipsPopovers@index')->name('ui-tooltips-popovers');
Route::get('/ui/typography', $controller_path . '\user_interface\Typography@index')->name('ui-typography');

// extended ui
Route::get('/extended/ui-perfect-scrollbar', $controller_path . '\extended_ui\PerfectScrollbar@index')->name('extended-ui-perfect-scrollbar');
Route::get('/extended/ui-text-divider', $controller_path . '\extended_ui\TextDivider@index')->name('extended-ui-text-divider');

// icons
Route::get('/icons/boxicons', $controller_path . '\icons\Boxicons@index')->name('icons-boxicons');

// form elements
Route::get('/forms/basic-inputs', $controller_path . '\form_elements\BasicInput@index')->name('forms-basic-inputs');
Route::get('/forms/input-groups', $controller_path . '\form_elements\InputGroups@index')->name('forms-input-groups');

// form layouts
Route::get('/form/layouts-vertical', $controller_path . '\form_layouts\VerticalForm@index')->name('form-layouts-vertical');
Route::get('/form/layouts-horizontal', $controller_path . '\form_layouts\HorizontalForm@index')->name('form-layouts-horizontal');

// tables
Route::get('/tables/basic', $controller_path . '\tables\Basic@index')->name('tables-basic');



//Front Routes

Route::get('/', $front_path . '\FrontController@index')->name('front.index');

//New Routes
Route::get('/login', $controller_path . '\User\LoginController@showLoginForm')->name('login');
Route::post('/login',  $controller_path . '\User\LoginController@login')->name('user.login.submit');
Route::post('/subscribe',  $controller_path . '\Front\FrontController@subscribe')->name('subscribe.submit');
Route::post('/contact-email',  $controller_path . '\Front\FrontController@contact')->name('contact.submit');

Route::get('/register', $controller_path . '\User\RegisterController@showRegisterForm')->name('register');
Route::post('/register',  $controller_path . '\User\RegisterController@register')->name('user.register.submit');

Route::get('/verify/{token}', $controller_path . '\User\RegisterController@token')->name('verify.register');

Route::get('/forgot', $controller_path . '\User\RegisterController@showForgotForm')->name('forgot');
Route::post('/forgot',  $controller_path . '\User\RegisterController@forgot')->name('user.forgot.submit');

Route::get('/chatwithus/{slug}', $controller_path . '\chat\NewChat@embedLink')->name('chat.embed');
Route::get('/embed/{slug}', $controller_path . '\chat\NewChat@embedCode')->name('chat.embed.code');
Route::get('/integrated/{slug}', $controller_path . '\chat\NewChat@chatIntegrated')->name('chat.integrated');

Route::get('/chatdefault/{slug}', $controller_path . '\chat\NewChat@chatButton')->name('chat.button');


Route::post('/widgets/info', $controller_path . '\chat\NewChat@widgetinfo')->name('chat.widget.info');
Route::get('/{slug}/widget.js', $controller_path . '\chat\NewChat@widgetdCode')->name('chat.widget.code');
Route::get('/{slug}/styles.css', $controller_path . '\chat\NewChat@widgetStyles')->name('chat.widget.styles');
Route::get('/qqdoit/{slug}', $controller_path . '\chat\NewChat@createChat')->name('chat.widget.create');
Route::get('/oldchats', $controller_path . '\chat\NewChat@getOldChats')->name('chat.widget.oldchats');

Route::post('/embed/broadcast', $controller_path . '\User\PusherController@broadcasto');
Route::post('/embed/receive', $controller_path . '\User\PusherController@receiveo');
Route::post('/embed/info', $controller_path . '\chat\NewChat@info');


Route::group(['middleware' => 'auth'], function () {

  $controller_path = 'App\Http\Controllers';
  $user_path = 'App\Http\Controllers\User';

  Route::group(['middleware' => 'admin'], function () {
    //Admin Routes Start
    $admin_path = 'App\Http\Controllers\Admin';

  Route::get('/dashboard', $admin_path . '\DashboardController@index')->name('core.dashboard');
  Route::get('/manage-plans', $admin_path . '\PlanController@index')->name('admin.plans');
  Route::post('/plan-submit', $admin_path . '\PlanController@submit')->name('plan.create');
  Route::post('/plan-update', $admin_path . '\PlanController@update')->name('plan.update');
  Route::get('/plan-delete/{id}', $admin_path . '\PlanController@plandelete')->name('plan.delete');
  Route::get('/gateways', $admin_path . '\Settings@gateway')->name('admin.gateway');
  Route::post('/gateway/update/{gateway}', $admin_path . '\Settings@gatewayUpdate')->name('gateway.update');

  Route::get('/subscriptions', $admin_path . '\FinanceController@subscriptions')->name('admin.user.subscriptions');
  Route::get('/payments', $admin_path . '\FinanceController@payments')->name('admin.user.payments');


  Route::get('/manage-user', $admin_path . '\UserController@index')->name('manage.user');
  Route::post('/user-submit', $admin_path . '\UserController@submit')->name('user.create');
  Route::post('/user-update/{id}', $admin_path . '\UserController@update')->name('user.update');
  Route::post('/user-balance/{id}', $admin_path . '\UserController@balance')->name('user.balance');
  Route::post('/user-security/{id}', $admin_path . '\UserController@passwords')->name('user.security.update');
  Route::get('/user-status/{id}', $admin_path . '\UserController@status')->name('user.status');
  Route::get('/user/{id}/details', $admin_path . '\UserController@view')->name('user.view');
  Route::get('/user/{id}/security', $admin_path . '\UserController@security')->name('user.security');
    Route::get('/user/{id}/billing', $admin_path . '\UserController@billing')->name('user.billing');
    Route::get('/user/{id}/cancelsub', $admin_path . '\UserController@cancelSub')->name('user.subscription.cancel');
    Route::post('/user/{id}/billing', $admin_path . '\UserController@billingUpdate')->name('user.billing.update');

  Route::get('/manage/pages', $admin_path . '\PageController@index')->name('pages.index');
  Route::get('/manage/pages/create', $admin_path . '\PageController@create')->name('pages.create');
  Route::get('/manage/pages/{id}', $admin_path . '\PageController@edit')->name('pages.edit');
  Route::get('/manage/pages/delete/{id}', $admin_path . '\PageController@delete')->name('pages.delete');
  Route::post('/manage/pages/submit', $admin_path . '\PageController@submit')->name('pages.submit');
  Route::post('/manage/pages/order', $admin_path . '\PageController@menuOrder')->name('pages.order');
  Route::post('/manage/pages/update/{id}', $admin_path . '\PageController@update')->name('pages.update');


    Route::get('/settings/general', $admin_path . '\Settings@index')->name('settings.index');
    Route::get('/settings/contact', $admin_path . '\Settings@contact')->name('settings.contact');
    Route::get('/settings/smtp', $admin_path . '\Settings@smtp')->name('settings.smpt');
  Route::get('/settings/logo', $admin_path . '\Settings@logo')->name('settings.logo');
  Route::post('/settings/update', $admin_path . '\Settings@update')->name('settings.update');
  Route::post('/settings/update-image', $admin_path . '\Settings@updateImage')->name('settings.update.image');

  //Homepage

  Route::get('/homepage/welcome', $admin_path . '\HomePageContoller@index')->name('homepage.index');
  Route::get('/homepage/login', $admin_path . '\HomePageContoller@login')->name('homepage.login');
  Route::get('/homepage/why', $admin_path . '\HomePageContoller@why')->name('homepage.why');
  Route::get('/homepage/how', $admin_path . '\HomePageContoller@how')->name('homepage.how');
  Route::get('/homepage/testimonials', $admin_path . '\HomePageContoller@testimonials')->name('homepage.testimonials');
  Route::post('/homepage/update', $admin_path . '\HomePageContoller@update')->name('homepage.update');
  Route::post('/contents/store', $admin_path . '\HomePageContoller@contentStore')->name('contents.create');
  Route::post('/contents/update', $admin_path . '\HomePageContoller@contentUpdate')->name('contents.update');
  Route::get('/contents/delete/{id}', $admin_path . '\HomePageContoller@contentDelete')->name('contents.delete');


  Route::get('homepage/faqs', $admin_path . '\HomePageContoller@faqs')->name('homepage.faqs');
  Route::post('/faq/store', $admin_path . '\HomePageContoller@faqCreate')->name('faq.create');
  Route::post('/faq/update', $admin_path . '\HomePageContoller@faqUpdate')->name('faq.update');
  Route::get('/faq/delete/{id}', $admin_path . '\HomePageContoller@faqDelete')->name('faq.delete');


    //Admin Routes End
  });

  //User Routes
  Route::get('/user/dashboard', $user_path . '\Dashboard@index')->name('user.dashboard');
  Route::get('/logout',  $controller_path . '\User\LoginController@logout')->name('user.logout');

  Route::get('/user/login', $controller_path . '\User\LoginController@showLoginForm')->name('user-login');
  Route::get('/train', $controller_path . '\User\TrainController@trainIndex')->name('user-train');
  Route::post('/train-submit', $controller_path . '\User\TrainController@trainSubmit')->name('train-submit');
  Route::get('/train-delete/{id}', $controller_path . '\User\TrainController@traindelete')->name('train-delete');
  Route::get('/instruct-delete/{id}', $controller_path . '\User\TrainController@instructdelete')->name('instruct-delete');


  // Route::get('/aisetup', $controller_path . '\User\TrainController@instructIndex')->name('user-instruct');
  // Route::post('/instruct-submit', $controller_path . '\User\TrainController@instructSubmit')->name('instruct-submit');
  Route::post('/chat-submit', $controller_path . '\User\TrainController@chatSubmit')->name('chat-submit');

  Route::get('/index-chat', $controller_path . '\User\PusherController@index');
  Route::get('/index-chat', $controller_path . '\User\PusherController@index');
  Route::post('/broadcast', $controller_path . '\User\PusherController@broadcast');
  Route::post('/receive', $controller_path . '\User\PusherController@receive');

  Route::get('/widget', $controller_path . '\chat\NewChat@widgets')->name('chat-widgets');
  Route::get('/chat/status/{id}/{status}', $controller_path . '\chat\NewChat@aistatus')->name('chat-aistatus');
  // tables
  Route::get('/chats', $controller_path . '\chat\NewChat@index')->name('chat-basic');
  Route::get('/customer-chats', $controller_path . '\chat\NewChat@chatIndex')->name('chat.index');
  Route::get('/support-chats/{ass_id}', $controller_path . '\chat\NewChat@supportchats')->name('chat.support');
  Route::get('/support-chats/{id}/{ass_id}', $controller_path . '\chat\NewChat@chat')->name('chat.details');

  //Plan Routes
  Route::get('/subscription-plans', $controller_path . '\User\SubscriptionController@index')->name('subscription.index');
  Route::get('/subscription-checkout/{id}', $controller_path . '\User\SubscriptionController@plancheckout')->name('subscription.checkout');
  Route::post('/checkout-submit', $controller_path . '\User\SubscriptionController@submitcheckout')->name('subscription.checkout.submit');

  //Assistant Route
  Route::get('/manage-assistants', $user_path . '\AssistantController@index')->name('manage.assistant');
  Route::get('/assistant-create', $user_path . '\AssistantController@create')->name('assistant.create');
  Route::post('/assistant-submit', $user_path . '\AssistantController@submit')->name('assistant.submit');
  Route::get('/assistant-delete/{id}', $user_path . '\AssistantController@delete')->name('assistant.delete');
  Route::post('/assistant-update/{id}', $user_path . '\AssistantController@update')->name('assistant.update');
  Route::post('/assistant-domain/{id}', $user_path . '\AssistantController@domain')->name('assistant.domain');
  Route::get('/assistant-edit/{id}', $user_path . '\AssistantController@edit')->name('assistant.edit');
  Route::get('/assistant-config/{id}', $user_path . '\AssistantController@config')->name('assistant.config');


  Route::post('/assistant-field-submit', $user_path . '\AssistantController@fieldsubmit')->name('assistant.field.submit');
  Route::get('/assistant-field-delete/{id}', $user_path . '\AssistantController@fielddelete')->name('assistant.field.delete');
  Route::post('/assistant-field-update', $user_path . '\AssistantController@fieldupdate')->name('assistant.field.update');

  //Instructions Route
  Route::get('/assistants-train/{id}', $user_path . '\TrainController@index')->name('train.assistant');
  Route::post('/train-submit/{id}', $user_path . '\TrainController@submit')->name('train.submit');
  Route::get('/train-delete/{id}', $user_path . '\TrainController@delete')->name('train.delete');
  Route::post('/train-update/{id}', $user_path . '\TrainController@update')->name('train.update');


  Route::get('/user/profile', $controller_path . '\User\UserController@profile')->name('user.profile');
  Route::post('/user/pro/update', $controller_path . '\User\UserController@profileupdate')->name('profile.update');
  Route::get('/user/password', $controller_path . '\User\UserController@changepass')->name('user.password');
  Route::get('/user/billing', $controller_path . '\User\UserController@billing')->name('account.billing');
  Route::post('/user/pass/update', $controller_path . '\User\UserController@changepassupdate')->name('password.update');


  Route::get('/user/configs', $controller_path . '\User\Settings@index')->name('user.config');
  Route::post('/user/configs/update/{id}', $controller_path . '\User\Settings@configUpdate')->name('user.config.update');

  Route::get('/user/responders', $controller_path . '\User\Settings@responder')->name('user.responder');
  Route::post('/user/responders/update/{id}', $controller_path . '\User\Settings@responderUpdate')->name('user.responder.update');


  Route::get('/user/my-payments', $user_path . '\ReportController@payments')->name('account.payments');
  Route::get('/user/credit-history', $user_path . '\ReportController@creditHistory')->name('account.credit.history');

});


Route::get('notify/stripe',$gateway_path . '\Stripe@notify')->name('stripe.notify');
Route::get('notify/paypal',$gateway_path . '\Paypal@notify')->name('paypal.notify');


// ============================================================
// SUPER ADMIN ROUTES
// ============================================================
Route::group(['prefix' => 'superadmin', 'middleware' => ['auth', 'superadmin']], function () {
  $sa_path = 'App\Http\Controllers\SuperAdmin';

  // Dashboard
  Route::get('/dashboard', $sa_path . '\DashboardController@index')->name('superadmin.dashboard');

  // Tenant Management
  Route::get('/tenants', $sa_path . '\TenantManagementController@index')->name('superadmin.tenants');
  Route::post('/tenants/store', $sa_path . '\TenantManagementController@store')->name('superadmin.tenants.store');
  Route::get('/tenants/{id}', $sa_path . '\TenantManagementController@show')->name('superadmin.tenants.show');
  Route::post('/tenants/{id}/update', $sa_path . '\TenantManagementController@update')->name('superadmin.tenants.update');
  Route::get('/tenants/{id}/delete', $sa_path . '\TenantManagementController@destroy')->name('superadmin.tenants.destroy');

  // Tenant Plans
  Route::get('/tenant-plans', $sa_path . '\TenantPlanController@index')->name('superadmin.tenant-plans');
  Route::post('/tenant-plans/store', $sa_path . '\TenantPlanController@store')->name('superadmin.tenant-plans.store');
  Route::post('/tenant-plans/{id}/update', $sa_path . '\TenantPlanController@update')->name('superadmin.tenant-plans.update');
  Route::get('/tenant-plans/{id}/delete', $sa_path . '\TenantPlanController@destroy')->name('superadmin.tenant-plans.destroy');
});


// ============================================================
// TENANT OWNER ROUTES
// ============================================================
Route::group(['prefix' => 'tenant', 'middleware' => ['auth', 'tenant.owner']], function () {
  $t_path = 'App\Http\Controllers\Tenant';

  // Dashboard
  Route::get('/dashboard', $t_path . '\TenantDashboardController@index')->name('tenant.dashboard');

  // Branding
  Route::get('/branding', $t_path . '\BrandingController@index')->name('tenant.branding.index');
  Route::post('/branding/update', $t_path . '\BrandingController@update')->name('tenant.branding.update');

  // Domain
  Route::get('/domain', $t_path . '\DomainController@index')->name('tenant.domain');
  Route::post('/domain/update', $t_path . '\DomainController@update')->name('tenant.domain.update');
  Route::post('/domain/verify', $t_path . '\DomainController@verify')->name('tenant.domain.verify');
  Route::get('/domain/remove', $t_path . '\DomainController@removeDomain')->name('tenant.domain.remove');

  // User Management
  Route::get('/users', $t_path . '\TenantUserController@index')->name('tenant.users');
  Route::post('/users/store', $t_path . '\TenantUserController@store')->name('tenant.users.store');
  Route::get('/users/{id}', $t_path . '\TenantUserController@show')->name('tenant.users.show');
  Route::post('/users/{id}/update', $t_path . '\TenantUserController@update')->name('tenant.users.update');
  Route::post('/users/{id}/password', $t_path . '\TenantUserController@updatePassword')->name('tenant.users.password');
  Route::get('/users/{id}/delete', $t_path . '\TenantUserController@destroy')->name('tenant.users.destroy');
  Route::post('/users/invite', $t_path . '\TenantUserController@invite')->name('tenant.users.invite');

  // API Settings
  Route::get('/api-settings', $t_path . '\ApiSettingsController@index')->name('tenant.api-settings');
  Route::post('/api-settings/update', $t_path . '\ApiSettingsController@update')->name('tenant.api-settings.update');

  // Payment Settings
  Route::get('/payment-settings', $t_path . '\PaymentSettingsController@index')->name('tenant.payment-settings');
  Route::post('/payment-settings/update', $t_path . '\PaymentSettingsController@update')->name('tenant.payment-settings.update');

  // Credits
  Route::get('/credits', $t_path . '\CreditController@index')->name('tenant.credits');
  Route::post('/credits/distribute', $t_path . '\CreditController@distribute')->name('tenant.credits.distribute');
});


Route::get('/{slug}', $front_path . '\FrontController@pages')->name('front.page');
