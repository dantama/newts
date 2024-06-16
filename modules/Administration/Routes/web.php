<?php

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

use Modules\Administration\Http\Middleware\IsAdminMiddleware;
use Modules\Administration\Http\Middleware\AdminableMiddleware;

Route::prefix('admin')->name('administration::')->middleware('auth')->group(function () {
    Route::middleware([IsAdminMiddleware::class, AdminableMiddleware::class])->group(function () {
        Route::redirect('/', '/dashboard')->name('index');
        // Dashboard
        Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

        Route::get('/statistic', 'StatisticController@index')->name('statistic');
        Route::get('/warriorstatisticprovince', 'StatisticController@statisticWarriorProvince')->name('warrior-statistic-province');

        Route::get('/cadrestatistic', 'StatisticCadreController@index')->name('cadre-statistic');
        Route::get('/cadrestatisticprovice', 'StatisticCadreController@statisticCadreProvince')->name('cadre-statistic-province');

        Route::get('/student-statistic', 'StatisticStudentController@index')->name('student-statistic');
        Route::get('/student-statistic-province', 'StatisticStudentController@statisticStudentProvince')->name('student-statistic-province');

        // Blog
        Route::name('blog.')->prefix('blog')->namespace('Blog')->group(function () {
            // Posts
            Route::put('/posts/{post}/approval', 'PostController@approval')->name('posts.approval');
            Route::put('/posts/{post}/restore', 'PostController@restore')->name('posts.restore');
            Route::delete('/posts/{post}/kill', 'PostController@kill')->name('posts.kill');
            Route::resource('/posts', 'PostController');
            // Comments
            Route::put('/comments/{comment}/approve', 'PostCommentController@approve')->name('comments.approve');
            Route::delete('/comments/{comment}', 'PostCommentController@destroy')->name('comments.destroy');
            // Categories
            Route::resource('/categories', 'CategoryController')->except(['create', 'show']);
        });

        // Organisasi
        Route::name('managements.')->prefix('managements')->namespace('Management')->group(function () {
            // Pimwil
            Route::namespace('Center')->group(function () {
                // Data PP
                Route::resource('centers', 'CenterController');

                // Pengurus PP
                Route::resource('center-managers', 'CenterManagerController', ['names' => 'centers-managers'])->parameters(['center-managers' => 'manager']);
                Route::put('center-managers/{manager}/restore', 'CenterManagerController@restore')->name('centers-managers.restore');
                Route::put('center-managers/{manager}/adminable', 'CenterManagerController@adminable')->name('centers-managers.adminable');
                Route::delete('center-managers/{manager}/kill', 'CenterManagerController@kill')->name('centers-managers.kill');
            });

            // Pimwil
            Route::namespace('Province')->group(function () {
                // Data Wilyah
                Route::resource('provinces', 'ProvinceController');
                Route::put('provinces/{province}/update', 'ProvinceController@update')->name('provinces.update');

                // Pengurus Wilyah
                Route::resource('province-managers', 'ProvinceManagerController', ['names' => 'provinces-managers'])->parameters(['province-managers' => 'manager']);
                Route::put('province-managers/{manager}/restore', 'ProvinceManagerController@restore')->name('provinces-managers.restore');
                Route::put('province-managers/{manager}/adminable', 'ProvinceManagerController@adminable')->name('provinces-managers.adminable');
                Route::delete('province-managers/{manager}/kill', 'ProvinceManagerController@kill')->name('provinces-managers.kill');
            });


            // Perwil
            Route::namespace('Perwil')->group(function () {
                // Data Perwil
                Route::resource('perwil', 'PerwilController', ['names' => 'perwil'])->parameters(['perwil' => 'perwil']);

                // Pengurus Perwil
                Route::resource('perwil-managers', 'PerwilManagerController', ['names' => 'perwil-managers'])->parameters(['perwil_manager' => 'perwil_manager']);
                Route::put('perwil-managers/{perwil_manager}/restore', 'PerwilManagerController@restore')->name('perwil-managers.restore');
                Route::put('perwil-managers/{perwil_manager}/adminable', 'PerwilManagerController@adminable')->name('perwil-managers.adminable');
                Route::delete('perwil-managers/{perwil_manager}/kill', 'PerwilManagerController@kill')->name('perwil-managers.kill');
            });

            // Pimda
            Route::namespace('Regency')->group(function () {
                // Data Daerah

                Route::get('regencies/open-registers', 'RegencyController@registers')->name('regencies.open-registers');
                Route::put('regencies/updateregisters', 'RegencyController@updateregisters')->name('regencies.updateregisters');
                Route::put('regencies/{regency}/resetregisters', 'RegencyController@resetregisters')->name('regencies.resetregisters');

                Route::resource('regencies', 'RegencyController', [
                    'names' => 'regencies',
                    'only' => ['index', 'store', 'show', 'update', 'destroy']
                ])->parameters(['regencies' => 'id']);


                // Pengurus Daerah
                Route::resource('regency-managers', 'RegencyManagerController', ['names' => 'regencies-managers'])->parameters(['regency-managers' => 'manager']);
                Route::put('regency-managers/{manager}/restore', 'RegencyManagerController@restore')->name('regencies-managers.restore');
                Route::put('regency-managers/{manager}/adminable', 'RegencyManagerController@adminable')->name('regencies-managers.adminable');
                Route::delete('regency-managers/{manager}/kill', 'RegencyManagerController@kill')->name('regencies-managers.kill');
            });

            // Distric
            Route::namespace('District')->group(function () {
                // Data Daerah
                Route::resource('districts', 'DistrictController', [
                    'names' => 'districts',
                    'only' => ['index', 'store']
                ])->parameters(['districts' => 'id']);
                Route::get('districts/registers', 'DistrictController@registers')->name('districts.registers');

                // Pengurus Daerah
                Route::resource('district-managers', 'DistrictManagerController', ['names' => 'districts-managers'])->parameters(['district-managers' => 'manager']);
                Route::put('district-managers/{manager}/restore', 'DistrictManagerController@restore')->name('districts-managers.restore');
                Route::put('district-managers/{manager}/adminable', 'DistrictManagerController@adminable')->name('districts-managers.adminable');
                Route::delete('district-managers/{manager}/kill', 'DistrictManagerController@kill')->name('districts-managers.kill');
            });
        });

        Route::name('members.')->prefix('members')->namespace('Member')->group(function () {

            // Account
            Route::get('/account/{account}/show', 'AllMemberController@show')->name('account.show');
            Route::get('/account/{account}/card', 'AllMemberController@card')->name('account.card');
            Route::get('/account/{account}/profile', 'AllMemberController@profile')->name('account.profile');
            Route::get('/account/{account}/email', 'AllMemberController@email')->name('account.email');
            Route::get('/account-email/reverify', 'AllMemberController@reverify')->name('account.email-reverify');
            Route::get('/account/{account}/phone', 'AllMemberController@phone')->name('account.phone');
            Route::get('/account/{account}/organizations', 'AllMemberController@organizations')->name('account.organizations');
            Route::get('/account/{account}/nbts', 'AllMemberController@nbts')->name('account.nbts');
            Route::get('/account/{account}/nbm', 'AllMemberController@nbm')->name('account.nbm');
            Route::get('/account/{account}/joined', 'AllMemberController@joined')->name('account.joined');
            Route::get('/account/{account}/address', 'AllMemberController@address')->name('account.address');
            Route::get('/account/{account}/avatar', 'AllMemberController@avatar')->name('account.avatar');
            Route::get('/account/{account}/level', 'AllMemberController@level')->name('account.level');
            Route::put('/account/{account}/phone', 'AllMemberController@phoneupdate')->name('account.phone-update');
            Route::put('/account/{account}/emailupdate', 'AllMemberController@emailupdate')->name('account.email-update');
            Route::put('/account/{account}/profile-update', 'AllMemberController@profileupdate')->name('account.profile-update');
            Route::put('/account/{account}/organization-update', 'AllMemberController@organizationupdate')->name('account.organization-update');
            Route::put('/account/{account}/restore', 'AllMemberController@restore')->name('account.restore');
            Route::put('/account/{account}/nbts-update', 'AllMemberController@nbtsupdate')->name('account.nbts-update');
            Route::put('/account/{account}/nbm-update', 'AllMemberController@nbmupdate')->name('account.nbm-update');
            Route::put('/account/{account}/joined-update', 'AllMemberController@joinedupdate')->name('account.joined-update');
            Route::put('/account/{account}/address-update', 'AllMemberController@addressupdate')->name('account.address-update');
            Route::put('/account/{account}/level-update', 'AllMemberController@levelupdate')->name('account.level-update');
            Route::put('/account/{user}/reset-password', 'AllMemberController@repass')->name('account.reset-password');
            Route::post('/account/avatar-update', 'AllMemberController@avatarupdate')->name('account.avatar-update');
            Route::post('/account/import-account', 'AllMemberController@importaccount')->name('account.import-account');
            Route::delete('/account/{account}/kill', 'AllMemberController@kill')->name('account.kill');
            Route::resource('account', 'AllMemberController', ['names' => 'account'])->parameters(['account' => 'account']);

            // Warrior
            Route::get('/warriors/download-all-warriors', 'WarriorController@downloadpdf')->name('warriors.download-all-warriors');
            Route::get('/warriors/{warrior}/show', 'WarriorController@show')->name('warriors.show');
            Route::get('/warriors/{warrior}/card', 'WarriorController@card')->name('warriors.card');
            Route::get('/warriors/{warrior}/profile', 'WarriorController@profile')->name('warriors.profile');
            Route::get('/warriors/{warrior}/email', 'WarriorController@email')->name('warriors.email');
            Route::get('/warriors-email/reverify', 'WarriorController@reverify')->name('warriors.email-reverify');
            Route::get('/warriors/{warrior}/phone', 'WarriorController@phone')->name('warriors.phone');
            Route::get('/warriors/{warrior}/nbts', 'WarriorController@nbts')->name('warriors.nbts');
            Route::get('/warriors/{warrior}/organizations', 'WarriorController@organizations')->name('warriors.organizations');
            Route::get('/warriors/{warrior}/nbm', 'WarriorController@nbm')->name('warriors.nbm');
            Route::get('/warriors/{warrior}/joined', 'WarriorController@joined')->name('warriors.joined');
            Route::get('/warriors/{warrior}/address', 'WarriorController@address')->name('warriors.address');
            Route::get('/warriors/{warrior}/avatar', 'WarriorController@avatar')->name('warriors.avatar');
            Route::get('/warriors/{warrior}/level', 'WarriorController@level')->name('warriors.level');
            Route::put('/warriors/{warrior}/profile-update', 'WarriorController@profileupdate')->name('warriors.profile-update');
            Route::put('/warriors/{warrior}/restore', 'WarriorController@restore')->name('warriors.restore');
            Route::put('/warriors/{warrior}/emailupdate', 'WarriorController@emailupdate')->name('warriors.email-update');
            Route::put('/warriors/{warrior}/phone', 'WarriorController@phoneupdate')->name('warriors.phone-update');
            Route::put('/warriors/{warrior}/organization-update', 'WarriorController@organizationupdate')->name('warriors.organization-update');
            Route::put('/warriors/{warrior}/nbts-update', 'WarriorController@nbtsupdate')->name('warriors.nbts-update');
            Route::put('/warriors/{warrior}/nbm-update', 'WarriorController@nbmupdate')->name('warriors.nbm-update');
            Route::put('/warriors/{warrior}/joined-update', 'WarriorController@joinedupdate')->name('warriors.joined-update');
            Route::put('/warriors/{warrior}/address-update', 'WarriorController@addressupdate')->name('warriors.address-update');
            Route::put('/warriors/{warrior}/level-update', 'WarriorController@levelupdate')->name('warriors.level-update');
            Route::put('/warriors/{user}/reset-password', 'WarriorController@repass')->name('warriors.reset-password');
            Route::post('/warriors/avatar-update', 'WarriorController@avatarupdate')->name('warriors.avatar-update');
            Route::post('/warriors/import-warriors', 'WarriorController@importwarrior')->name('warriors.import-warriors');
            Route::delete('/warriors/{warrior}/kill', 'WarriorController@kill')->name('warriors.kill');
            Route::resource('warriors', 'WarriorController', ['names' => 'warriors'])->parameters(['warrior' => 'warrior']);

            // Perwil Warrior
            Route::get('/perwil-warriors/download-all-perwil-warriors', 'WarriorPerwilController@downloadpdf')->name('perwil-warriors.download-all-perwil-warriors');
            Route::get('/perwil-warriors/{perwil_warrior}/show', 'WarriorPerwilController@show')->name('perwil-warriors.show');
            Route::get('/perwil-warriors/{perwil_warrior}/card', 'WarriorPerwilController@card')->name('perwil-warriors.card');
            Route::get('/perwil-warriors/{perwil_warrior}/profile', 'WarriorPerwilController@profile')->name('perwil-warriors.profile');
            Route::get('/perwil-warriors/{perwil_warrior}/email', 'WarriorPerwilController@email')->name('perwil-warriors.email');
            Route::get('/perwil-warriors-email/reverify', 'WarriorPerwilController@reverify')->name('perwil-warriors.email-reverify');
            Route::get('/perwil-warriors/{perwil_warrior}/phone', 'WarriorPerwilController@phone')->name('perwil-warriors.phone');
            Route::get('/perwil-warriors/{perwil_warrior}/organizations', 'WarriorPerwilController@organizations')->name('perwil-warriors.organizations');
            Route::get('/perwil-warriors/{perwil_warrior}/nbts', 'WarriorPerwilController@nbts')->name('perwil-warriors.nbts');
            Route::get('/perwil-warriors/{perwil_warrior}/nbm', 'WarriorPerwilController@nbm')->name('perwil-warriors.nbm');
            Route::get('/perwil-warriors/{perwil_warrior}/joined', 'WarriorPerwilController@joined')->name('perwil-warriors.joined');
            Route::get('/perwil-warriors/{perwil_warrior}/address', 'WarriorPerwilController@address')->name('perwil-warriors.address');
            Route::get('/perwil-warriors/{perwil_warrior}/level', 'WarriorPerwilController@level')->name('perwil-warriors.level');
            Route::get('/perwil-warriors/{perwil_warrior}/avatar', 'WarriorPerwilController@avatar')->name('perwil-warriors.avatar');
            Route::put('/perwil-warriors/{perwil_warrior}/restore', 'WarriorPerwilController@restore')->name('perwil-warriors.restore');
            Route::put('/perwil-warriors/{perwil_warrior}/level-update', 'WarriorPerwilController@levelupdate')->name('perwil-warriors.level-update');
            Route::put('/perwil-warriors/{perwil_warrior}/profile-update', 'WarriorPerwilController@profileupdate')->name('perwil-warriors.profile-update');
            Route::put('/perwil-warriors/{perwil_warrior}/emailupdate', 'WarriorPerwilController@emailupdate')->name('perwil-warriors.email-update');
            Route::put('/perwil-warriors/{perwil_warrior}/phone', 'WarriorPerwilController@phoneupdate')->name('perwil-warriors.phone-update');
            Route::put('/perwil-warriors/{perwil_warrior}/organization-update', 'WarriorPerwilController@organizationupdate')->name('perwil-warriors.organization-update');
            Route::put('/perwil-warriors/{perwil_warrior}/nbts-update', 'WarriorPerwilController@nbtsupdate')->name('perwil-warriors.nbts-update');
            Route::put('/perwil-warriors/{perwil_warrior}/nbm-update', 'WarriorPerwilController@nbmupdate')->name('perwil-warriors.nbm-update');
            Route::put('/perwil-warriors/{perwil_warrior}/joined-update', 'WarriorPerwilController@joinedupdate')->name('perwil-warriors.joined-update');
            Route::put('/perwil-warriors/{perwil_warrior}/address-update', 'WarriorPerwilController@addressupdate')->name('perwil-warriors.address-update');
            Route::put('/perwil-warriors/{user}/reset-password', 'WarriorPerwilController@repass')->name('perwil-warriors.reset-password');
            Route::post('/perwil-warriors/avatar-update', 'WarriorPerwilController@avatarupdate')->name('perwil-warriors.avatar-update');
            Route::post('/perwil-warriors/import-perwil-warriors', 'WarriorPerwilController@importwarrior')->name('perwil-warriors.import-perwil-warriors');
            Route::delete('/perwil-warriors/{perwil_warrior}/kill', 'WarriorPerwilController@kill')->name('perwil-warriors.kill');
            Route::resource('perwil-warriors', 'WarriorPerwilController', ['names' => 'perwil-warriors'])->parameters(['perwil_warrior' => 'perwil_warrior']);

            // Cadre
            Route::get('/cadres/download-all-cadres', 'CadreController@downloadpdf')->name('cadres.download-all-cadres');
            Route::get('/cadres/{cadre}/show', 'CadreController@show')->name('cadres.show');
            Route::get('/cadres/{cadre}/card', 'CadreController@card')->name('cadres.card');
            Route::get('/cadres/{cadre}/profile', 'CadreController@profile')->name('cadres.profile');
            Route::get('/cadres/{cadre}/email', 'CadreController@email')->name('cadres.email');
            Route::get('/cadres-email/reverify', 'CadreController@reverify')->name('cadres.email-reverify');
            Route::get('/cadres/{cadre}/phone', 'CadreController@phone')->name('cadres.phone');
            Route::get('/cadres/{cadre}/organizations', 'CadreController@organizations')->name('cadres.organizations');
            Route::get('/cadres/{cadre}/nbts', 'CadreController@nbts')->name('cadres.nbts');
            Route::get('/cadres/{cadre}/nbm', 'CadreController@nbm')->name('cadres.nbm');
            Route::get('/cadres/{cadre}/joined', 'CadreController@joined')->name('cadres.joined');
            Route::get('/cadres/{cadre}/address', 'CadreController@address')->name('cadres.address');
            Route::get('/cadres/{cadre}/avatar', 'CadreController@avatar')->name('cadres.avatar');
            Route::get('/cadres/{cadre}/level', 'CadreController@level')->name('cadres.level');
            Route::put('/cadres/{cadre}/restore', 'CadreController@restore')->name('cadres.restore');
            Route::put('/cadres/{cadre}/profile-update', 'CadreController@profileupdate')->name('cadres.profile-update');
            Route::put('/cadres/{cadre}/emailupdate', 'CadreController@emailupdate')->name('cadres.email-update');
            Route::put('/cadres/{cadre}/phone', 'CadreController@phoneupdate')->name('cadres.phone-update');
            Route::put('/cadres/{cadre}/organization-update', 'CadreController@organizationupdate')->name('cadres.organization-update');
            Route::put('/cadres/{cadre}/nbts-update', 'CadreController@nbtsupdate')->name('cadres.nbts-update');
            Route::put('/cadres/{cadre}/nbm-update', 'CadreController@nbmupdate')->name('cadres.nbm-update');
            Route::put('/cadres/{cadre}/joined-update', 'CadreController@joinedupdate')->name('cadres.joined-update');
            Route::put('/cadres/{cadre}/address-update', 'CadreController@addressupdate')->name('cadres.address-update');
            Route::put('/cadres/{cadre}/level-update', 'CadreController@levelupdate')->name('cadres.level-update');
            Route::put('/cadres/{user}/reset-password', 'CadreController@repass')->name('cadres.reset-password');
            Route::post('/cadres/avatar-update', 'CadreController@avatarupdate')->name('cadres.avatar-update');
            Route::post('/cadres/import-cadres', 'CadreController@importcadre')->name('cadres.import-cadres');
            Route::delete('/cadres/{cadre}/kill', 'CadreController@kill')->name('cadres.kill');
            Route::resource('cadres', 'CadreController', ['names' => 'cadres'])->parameters(['cadre' => 'cadre']);

            // Perwil Cadre
            Route::get('/perwil-cadres/download-all-perwil-cadres', 'CadrePerwilController@downloadpdf')->name('perwil-cadres.download-all-perwil-cadres');
            Route::get('/perwil-cadres/{perwil_cadre}/show', 'CadrePerwilController@show')->name('perwil-cadres.show');
            Route::get('/perwil-cadres/{perwil_cadre}/card', 'CadrePerwilController@card')->name('perwil-cadres.card');
            Route::get('/perwil-cadres/{perwil_cadre}/profile', 'CadrePerwilController@profile')->name('perwil-cadres.profile');
            Route::get('/perwil-cadres/{perwil_cadre}/email', 'CadrePerwilController@email')->name('perwil-cadres.email');
            Route::get('/perwil-cadres-email/reverify', 'CadrePerwilController@reverify')->name('perwil-cadres.email-reverify');
            Route::get('/perwil-cadres/{perwil_cadre}/phone', 'CadrePerwilController@phone')->name('perwil-cadres.phone');
            Route::get('/perwil-cadres/{perwil_cadre}/organizations', 'CadrePerwilController@organizations')->name('perwil-cadres.organizations');
            Route::get('/perwil-cadres/{perwil_cadre}/nbts', 'CadrePerwilController@nbts')->name('perwil-cadres.nbts');
            Route::get('/perwil-cadres/{perwil_cadre}/nbm', 'CadrePerwilController@nbm')->name('perwil-cadres.nbm');
            Route::get('/perwil-cadres/{perwil_cadre}/joined', 'CadrePerwilController@joined')->name('perwil-cadres.joined');
            Route::get('/perwil-cadres/{perwil_cadre}/address', 'CadrePerwilController@address')->name('perwil-cadres.address');
            Route::get('/perwil-cadres/{perwil_cadre}/avatar', 'CadrePerwilController@avatar')->name('perwil-cadres.avatar');
            Route::get('/perwil-cadres/{perwil_cadre}/level', 'CadrePerwilController@level')->name('perwil-cadres.level');
            Route::put('/perwil-cadres/{perwil_cadre}/restore', 'CadrePerwilController@restore')->name('perwil-cadres.restore');
            Route::put('/perwil-cadres/{perwil_cadre}/profile-update', 'CadrePerwilController@profileupdate')->name('perwil-cadres.profile-update');
            Route::put('/perwil-cadres/{perwil_cadre}/emailupdate', 'CadrePerwilController@emailupdate')->name('perwil-cadres.email-update');
            Route::put('/perwil-cadres/{perwil_cadre}/phone', 'CadrePerwilController@phoneupdate')->name('perwil-cadres.phone-update');
            Route::put('/perwil-cadres/{perwil_cadre}/organization-update', 'CadrePerwilController@organizationupdate')->name('perwil-cadres.organization-update');
            Route::put('/perwil-cadres/{perwil_cadre}/nbts-update', 'CadrePerwilController@nbtsupdate')->name('perwil-cadres.nbts-update');
            Route::put('/perwil-cadres/{perwil_cadre}/nbm-update', 'CadrePerwilController@nbmupdate')->name('perwil-cadres.nbm-update');
            Route::put('/perwil-cadres/{perwil_cadre}/joined-update', 'CadrePerwilController@joinedupdate')->name('perwil-cadres.joined-update');
            Route::put('/perwil-cadres/{perwil_cadre}/address-update', 'CadrePerwilController@addressupdate')->name('perwil-cadres.address-update');
            Route::put('/perwil-cadres/{perwil_cadre}/level-update', 'CadrePerwilController@levelupdate')->name('perwil-cadres.level-update');
            Route::put('/perwil-cadres/{user}/reset-password', 'CadrePerwilController@repass')->name('perwil-cadres.reset-password');
            Route::post('/perwil-cadres/avatar-update', 'CadrePerwilController@avatarupdate')->name('perwil-cadres.avatar-update');
            Route::post('/perwil-cadres/import-perwil-cadres', 'CadrePerwilController@importcadre')->name('perwil-cadres.import-perwil-cadres');
            Route::delete('/perwil-cadres/{perwil_cadre}/kill', 'CadrePerwilController@kill')->name('perwil-cadres.kill');
            Route::resource('perwil-cadres', 'CadrePerwilController', ['names' => 'perwil-cadres'])->parameters(['perwil_cadre' => 'perwil_cadre']);

            // Student
            Route::get('/students/download-all-students', 'StudentController@downloadpdf')->name('students.download-all-students');
            Route::get('/students/{student}/show', 'StudentController@show')->name('students.show');
            Route::get('/students/{student}/profile', 'StudentController@profile')->name('students.profile');
            Route::get('/students/{student}/email', 'StudentController@email')->name('students.email');
            Route::get('/students-email/reverify', 'StudentController@reverify')->name('students.email-reverify');
            Route::get('/students/{student}/phone', 'StudentController@phone')->name('students.phone');
            Route::get('/students/{student}/organizations', 'StudentController@organizations')->name('students.organizations');
            Route::get('/students/{student}/address', 'StudentController@address')->name('students.address');
            Route::get('/students/{student}/avatar', 'StudentController@avatar')->name('students.avatar');
            Route::get('/students/{student}/level', 'StudentController@level')->name('students.level');
            Route::get('/students/{student}/district', 'StudentController@district')->name('students.district');
            Route::put('/students/{student}/restore', 'StudentController@restore')->name('students.restore');
            Route::put('/students/{student}/profile-update', 'StudentController@profileupdate')->name('students.profile-update');
            Route::put('/students/{student}/emailupdate', 'StudentController@emailupdate')->name('students.email-update');
            Route::put('/students/{student}/phone', 'StudentController@phoneupdate')->name('students.phone-update');
            Route::put('/students/{student}/organization-update', 'StudentController@organizationupdate')->name('students.organization-update');
            Route::put('/students/{student}/address-update', 'StudentController@addressupdate')->name('students.address-update');
            Route::put('/students/{student}/level-update', 'StudentController@levelupdate')->name('students.level-update');
            Route::put('/students/{student}/district-update', 'StudentController@districtupdate')->name('students.district-update');
            Route::put('/students/{user}/reset-password', 'StudentController@repass')->name('students.reset-password');
            Route::post('/students/import-student', 'StudentController@importStudent')->name('students.import-student');
            Route::post('/students/avatar-update', 'StudentController@avatarupdate')->name('students.avatar-update');
            Route::delete('/students/{student}/kill', 'StudentController@kill')->name('students.kill');
            Route::resource('students', 'StudentController', ['names' => 'students'])->parameters(['students' => 'student']);

            // Perwil Student
            Route::get('/perwil-students/download-all-perwil-students', 'StudentPerwilController@downloadpdf')->name('perwil-students.download-all-perwil-students');
            Route::get('/perwil-students/{perwil_student}/show', 'StudentPerwilController@show')->name('perwil-students.show');
            Route::get('/perwil-students/{perwil_student}/profile', 'StudentPerwilController@profile')->name('perwil-students.profile');
            Route::get('/perwil-students/{perwil_student}/email', 'StudentPerwilController@email')->name('perwil-students.email');
            Route::get('/perwil-students-email/reverify', 'StudentPerwilController@reverify')->name('perwil-students.email-reverify');
            Route::get('/perwil-students/{perwil_student}/phone', 'StudentPerwilController@phone')->name('perwil-students.phone');
            Route::get('/perwil-students/{perwil_student}/organizations', 'StudentPerwilController@organizations')->name('perwil-students.organizations');
            Route::get('/perwil-students/{perwil_student}/address', 'StudentPerwilController@address')->name('perwil-students.address');
            Route::get('/perwil-students/{perwil_student}/avatar', 'StudentPerwilController@avatar')->name('perwil-students.avatar');
            Route::get('/perwil-students/{perwil_student}/level', 'StudentPerwilController@level')->name('perwil-students.level');
            Route::get('/perwil-students/{perwil_student}/district', 'StudentPerwilController@district')->name('perwil-students.district');
            Route::put('/perwil-students/{perwil_student}/restore', 'StudentPerwilController@restore')->name('perwil-students.restore');
            Route::put('/perwil-students/{perwil_student}/profile-update', 'StudentPerwilController@profileupdate')->name('perwil-students.profile-update');
            Route::put('/perwil-students/{perwil_student}/emailupdate', 'StudentPerwilController@emailupdate')->name('perwil-students.email-update');
            Route::put('/perwil-students/{perwil_student}/phone', 'StudentPerwilController@phoneupdate')->name('perwil-students.phone-update');
            Route::put('/perwil-students/{perwil_student}/organization-update', 'StudentPerwilController@organizationupdate')->name('perwil-students.organization-update');
            Route::put('/perwil-students/{perwil_student}/address-update', 'StudentPerwilController@addressupdate')->name('perwil-students.address-update');
            Route::put('/perwil-students/{perwil_student}/level-update', 'StudentPerwilController@levelupdate')->name('perwil-students.level-update');
            Route::put('/perwil-students/{perwil_student}/district-update', 'StudentPerwilController@districtupdate')->name('perwil-students.district-update');
            Route::put('/perwil-students/{user}/reset-password', 'StudentPerwilController@repass')->name('perwil-students.reset-password');
            Route::post('/perwil-students/import-student', 'StudentPerwilController@importStudent')->name('perwil-students.import-student');
            Route::post('/perwil-students/avatar-update', 'StudentPerwilController@avatarupdate')->name('perwil-students.avatar-update');
            Route::delete('/perwil-students/{perwil_student}/kill', 'StudentPerwilController@kill')->name('perwil-students.kill');
            Route::resource('perwil-students', 'StudentPerwilController', ['names' => 'perwil-students'])->parameters(['perwil_student' => 'perwil_student']);
        });

        Route::name('technical.')->prefix('technical')->namespace('Technical')->group(function () {

            // Center Coach
            Route::resource('center-coachs', 'CenterCoachController', ['names' => 'center-coachs'])->parameters(['coach' => 'coach']);
            Route::put('/center-coachs/{coach}/restore', 'CenterCoachController@restore')->name('center-coachs.restore');
            Route::delete('/center-coachs/{coach}/kill', 'CenterCoachController@kill')->name('center-coachs.kill');
            Route::delete('/center-coachs/{coach}/destroy', 'CenterCoachController@destroy')->name('center-coachs.destroy');
            Route::get('/center-coachs/{coach}/show', 'CenterCoachController@show')->name('center-coachs.show');
            Route::post('/center-coachs/{coach}/store-level', 'CenterCoachController@storeLevel')->name('center-coachs.store-level');

            // Province Coach
            Route::resource('province-coachs', 'ProvinceCoachController', ['names' => 'province-coachs'])->parameters(['coach' => 'coach']);
            Route::put('/province-coachs/{coach}/restore', 'ProvinceCoachController@restore')->name('province-coachs.restore');
            Route::delete('/province-coachs/{coach}/kill', 'ProvinceCoachController@kill')->name('province-coachs.kill');
            Route::delete('/province-coachs/{coach}/destroy', 'ProvinceCoachController@destroy')->name('province-coachs.destroy');
            Route::get('/province-coachs/{coach}/show', 'ProvinceCoachController@show')->name('province-coachs.show');
            Route::post('/province-coachs/{coach}/store-level', 'ProvinceCoachController@storeLevel')->name('province-coachs.store-level');

            // Regency Coach
            Route::resource('regency-coachs', 'RegencyCoachController', ['names' => 'regency-coachs'])->parameters(['coach' => 'coach']);
            Route::put('/regency-coachs/{coach}/restore', 'RegencyCoachController@restore')->name('regency-coachs.restore');
            Route::delete('/regency-coachs/{coach}/kill', 'RegencyCoachController@kill')->name('regency-coachs.kill');
            Route::delete('/regency-coachs/{coach}/destroy', 'RegencyCoachController@destroy')->name('regency-coachs.destroy');
            Route::get('/regency-coachs/{coach}/show', 'RegencyCoachController@show')->name('regency-coachs.show');
            Route::post('/regency-coachs/{coach}/store-level', 'RegencyCoachController@storeLevel')->name('regency-coachs.store-level');


            // Center Referee
            Route::resource('center-referees', 'CenterRefereeController', ['names' => 'center-referees'])->parameters(['referee' => 'referee']);
            Route::put('/center-referees/{referee}/restore', 'CenterRefereeController@restore')->name('center-referees.restore');
            Route::delete('/center-referees/{referee}/kill', 'CenterRefereeController@kill')->name('center-referees.kill');
            Route::delete('/center-referees/{referee}/destroy', 'CenterRefereeController@destroy')->name('center-referees.destroy');
            Route::get('/center-referees/{referee}/show', 'CenterRefereeController@show')->name('center-referees.show');
            Route::post('/center-referees/{referee}/store-level', 'CenterRefereeController@storeLevel')->name('center-referees.store-level');

            // Province Referee
            Route::resource('province-referees', 'ProvinceRefereeController', ['names' => 'province-referees'])->parameters(['referee' => 'referee']);
            Route::put('/province-referees/{referee}/restore', 'ProvinceRefereeController@restore')->name('province-referees.restore');
            Route::delete('/province-referees/{referee}/kill', 'ProvinceRefereeController@kill')->name('province-referees.kill');
            Route::delete('/province-referees/{referee}/destroy', 'ProvinceRefereeController@destroy')->name('province-referees.destroy');
            Route::get('/province-referees/{referee}/show', 'ProvinceRefereeController@show')->name('province-referees.show');
            Route::post('/province-referees/{referee}/store-level', 'ProvinceRefereeController@storeLevel')->name('province-referees.store-level');

            // Regency Referee
            Route::resource('regency-referees', 'RegencyRefereeController', ['names' => 'regency-referees'])->parameters(['referee' => 'referee']);
            Route::put('/regency-referees/{referee}/restore', 'RegencyRefereeController@restore')->name('regency-referees.restore');
            Route::delete('/regency-referees/{referee}/kill', 'RegencyRefereeController@kill')->name('regency-referees.kill');
            Route::delete('/regency-referees/{referee}/destroy', 'RegencyRefereeController@destroy')->name('regency-referees.destroy');
            Route::get('/regency-referees/{referee}/show', 'RegencyRefereeController@show')->name('regency-referees.show');
            Route::post('/regency-referees/{referee}/store-level', 'RegencyRefereeController@storeLevel')->name('regency-referees.store-level');
        });

        route::name('achievement.')->prefix('achievement')->namespace('Achievement')->group(function () {

            // Prestasi Internal tingkat Nasional 
            Route::resource('center-achievements', 'CenterAchievementController', ['names' => 'center-achievements'])->parameters(['achievement' => 'achievement']);
            Route::put('/center-achievements/{achievement}/restore', 'CenterAchievementController@restore')->name('center-achievements.restore');
            Route::delete('/center-achievements/{achievement}/destroy', 'CenterAchievementController@destroy')->name('center-achievements.destroy');
            Route::delete('/center-achievements/{achievement}/kill', 'CenterAchievementController@kill')->name('center-achievements.kill');
            Route::get('/center-achievements/{achievement}/show', 'CenterAchievementController@show')->name('center-achievements.show');

            // Prestasi Internal tingkat wilayah
            Route::resource('province-achievements', 'ProvinceAchievementController', ['names' => 'province-achievements'])->parameters(['achievement' => 'achievement']);
            Route::put('/province-achievements/{achievement}/restore', 'ProvinceAchievementController@restore')->name('province-achievements.restore');
            Route::delete('/province-achievements/{achievement}/destroy', 'ProvinceAchievementController@destroy')->name('province-achievements.destroy');
            Route::delete('/province-achievements/{achievement}/kill', 'ProvinceAchievementController@kill')->name('province-achievements.kill');
            Route::get('/province-achievements/{achievement}/show', 'ProvinceAchievementController@show')->name('province-achievements.show');

            // Prestasi Internal tingkat Daerah
            Route::resource('regency-achievements', 'RegencyAchievementController', ['names' => 'regency-achievements'])->parameters(['achievement' => 'achievement']);
            Route::put('/regency-achievements/{achievement}/restore', 'RegencyAchievementController@restore')->name('regency-achievements.restore');
            Route::delete('/regency-achievements/{achievement}/destroy', 'RegencyAchievementController@destroy')->name('regency-achievements.destroy');
            Route::delete('/regency-achievements/{achievement}/kill', 'RegencyAchievementController@kill')->name('regency-achievements.kill');
            Route::get('/regency-achievements/{achievement}/show', 'RegencyAchievementController@show')->name('regency-achievements.show');

            // Prestasi Eksternal
            // Route::resource('external-achievements', 'ExternalAchievementController',['names' => 'external-achievements'])->parameters(['achievement' => 'achievement']);
            // Route::put('/external-achievements/{achievement}/restore', 'ExternalAchievementController@restore')->name('external-achievements.restore');
            // Route::delete('/external-achievements/{achievement}/destroy', 'ExternalAchievementController@destroy')->name('external-achievements.destroy');
            // Route::delete('/external-achievements/{achievement}/kill', 'ExternalAchievementController@kill')->name('external-achievements.kill');

        });
    });
});
