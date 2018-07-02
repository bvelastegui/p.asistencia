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

use Illuminate\Support\Facades\Route;

// Authentication Routes...
$this->get('login', 'Auth\LoginController@showLoginForm')->name('login');
$this->post('login', 'Auth\LoginController@login');
$this->post('logout', 'Auth\LoginController@logout')->name('logout');

// Password Reset Routes...
$this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
$this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
$this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
$this->post('password/reset', 'Auth\ResetPasswordController@reset');

Route::get('/', 'HomeController@index')->name('home');
Route::resource('courses', 'CourseController');
Route::get('/schedules', 'ScheduleController@index')->name('schedules.index');
Route::get('/workDay/{date}/{subject}', 'WorkDayController@edit')->name('workDays.edit');
Route::post('/workDay/{date}/{subject}', 'WorkDayController@store')->name('workDays.store');
Route::put('/workDay/{date}/{subject}', 'WorkDayController@update')->name('workDays.update');
Route::get('/courses/{courseId}/students', 'CourseController@students')->name('courses.students');
Route::post('/courses/{courseId}/students', 'CourseController@storeStudents')->name('courses.students.store');
Route::get('/courses/{courseId}/subjects', 'CourseController@subjects')->name('courses.subjects');
Route::post('/courses/{courseId}/subjects', 'CourseController@storeSubjects')->name('courses.subjects.store');
Route::post('/courses/{courseId}/classSchedule', 'CourseController@storeClassSchedule')->name('courses.classSchedule.store');
Route::delete('/courses/{courseId}/classSchedule', 'CourseController@deleteClassSchedule')->name('courses.classSchedule.delete');
Route::get('/reports/{course}/{date?}','ReportsController@index')->name('reports.index');
Route::get('/users/changePassword','UserController@changePassword')->name('users.changePassword');
Route::post('/users/changePassword','UserController@storePassword')->name('users.storePassword');
Route::get('/users/{user?}','UserController@index')->name('users.index');
Route::put('/users/{user}','UserController@update')->name('users.update');
