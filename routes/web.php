<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForgotPasswordController;

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

/*prevenindo usuario autenticado acessar as paginas*/
Route::middleware(['validateRoute'])->group(function() {
    //rota publica
    Route::get('/', [UserController::class, 'index'])->name('user.index');

    //rota de login
    Route::get('entrar', [UserController::class, 'loginForm'])->name('user.login');    
    Route::get('entrar/admin', [UserController::class, 'loginForm'])->name('instructor.login');
    Route::post('/do/login', [AuthController::class, 'loginDo'])->name('user.do.login');

    Route::prefix('login/')->group(function () {
        Route::get('facebook', [AuthController::class, 'redirectToFace'])->name('user.login.facebook');
        Route::get('facebook/callback', [AuthController::class, 'handleFaceCallback']);
        Route::get('google', [AuthController::class, 'redirectToGoogle'])->name('user.login.google');
        Route::get('google/callback', [AuthController::class, 'handleGoogleCallback']);
    });
 
    Route::get('sobre', [UserController::class, 'aboutUs'])->name('user.about');
    Route::get('cursos', [UserController::class, 'courses'])->name('user.courses');
    Route::get('detalhes/{name}', [UserController::class, 'details'])->name('user.courses.details');
    
    //rota de pesquisar
    Route::get('/procurar', [UserController::class, 'inputSearch'])->name('user.search.courses');

    Route::get('cadastrar', [UserController::class, 'registerForm'])->name('user.create');
    Route::get('cadastrar/admin', [UserController::class, 'registerForm'])->name('instructor.create');
    Route::post('/create', [AuthController::class, 'store'])->name('user.store');

    Route::get('resetar/admin', [ForgotPasswordController::class, 'emailForm'])->name('admin.reset');
    Route::get('resetar/', [ForgotPasswordController::class, 'emailForm'])->name('user.reset');
});

//rota de logout
Route::get('/logout', [AuthController::class, 'logout'])->name('user.logout');

//rota de reset de senha
Route::post('/send/email', [ForgotPasswordController::class, 'validateEmail'])->name('user.send.email');
Route::get('/nova-senha/{token}', [ForgotPasswordController::class, 'resetForm'])->middleware('ValidateSession')->name('user.reseted');
Route::get('/nova-senha/{token}/{admin}', [ForgotPasswordController::class, 'resetForm'])->middleware('ValidateSession');
Route::post('/reset/password', [ForgotPasswordController::class, 'resetPassword'])->name('user.reset.password');

    
/*protegendo a rota do aluno*/
Route::middleware(['ProtectPage'])->group(function() {
    Route::get('/aluno', [App\Http\Controllers\StudentController::class, 'studentPage'])->middleware('PaymentStatus')->name('user.student'); 

    Route::get('/aula/{name}/{id}', [App\Http\Controllers\StudentController::class, 'lesson'])->middleware('validateLesson')->name('user.lesson'); 
    Route::post('/aluno/deletar/{id}', [App\Http\Controllers\StudentController::class, 'destroy'])->name('user.delete');
    Route::post('/update/student', [App\Http\Controllers\StudentController::class, 'updateStudent']);

    //planos
    Route::get('/planos', [App\Http\Controllers\PaymentController::class, 'plans'])->name('user.plan'); 
    
    //rota para gerar boletos
    Route::post('generate', [App\Http\Controllers\PaymentController::class, 'generateBankSlip'])->name('user.buy'); 

    Route::get('/procurar/cursos', [App\Http\Controllers\StudentController::class, 'searchCourses'])->name('student.search.courses');
    Route::get('/get-video/{link}/{token}', [App\Http\Controllers\StudentController::class, 'getVideo'])->middleware('validateURLToken')->name('student.video');
});

//rota restrita
Route::middleware(['ProtectPage'])->group(function() {
    Route::prefix('painel-administrativo')->group(function() {
        /*rota de listar usuarios*/
        Route::get('/', [App\Http\Controllers\UserAdminController::class, 'listUsers'])->name('admin.list.users');
        Route::get('/alunos', [App\Http\Controllers\UserAdminController::class, 'listStudents'])->name('admin.list.students');
        Route::get('/alunos/social', [App\Http\Controllers\UserAdminController::class, 'listSocialiteStudents'])->name('admin.list.socialite');

        Route::get('/instrutor', [App\Http\Controllers\UserAdminController::class, 'dashboard'])->name('instructor.dashboard');   
        Route::get('/permissao/{id}', [App\Http\Controllers\UserAdminController::class, 'editPermission'])->middleware('ProtectAdminPermission')->name('admin.edit.permission');   
        Route::get('/alunos/permissao/{id}', [App\Http\Controllers\UserAdminController::class, 'editStudentPermission'])->name('student.permission');   
        Route::get('/alunos/social/permissao/{id}', [App\Http\Controllers\UserAdminController::class, 'editSocialitePermission'])->name('student.socialite.permission');   

        Route::get('/configuracao', [App\Http\Controllers\UserAdminController::class, 'adminProfile'])->name('admin.profile');
        Route::get('/upload-videos', [App\Http\Controllers\UserAdminController::class, 'uploadPage'])->name('instructor.upload');
        Route::get('/videos', [App\Http\Controllers\UserAdminController::class, 'videoDetails'])->name('instructor.videos');
        Route::get('/videos/editar/{id}', [App\Http\Controllers\UserAdminController::class, 'editVideos'])->name('instructor.edit.videos');
    
        Route::post('/update/admin', [App\Http\Controllers\UserAdminController::class, 'updateAdmin']);
        Route::post('/deletar/{id}', [App\Http\Controllers\UserAdminController::class, 'destroy'])->name('admin.user.delete');
    });

    Route::post('/update-permissions', [App\Http\Controllers\UserAdminController::class, 'updatePermission'])->name('update.permission');
    Route::post('/update-payment-status', [App\Http\Controllers\UserAdminController::class, 'updatePaymentStatus'])->name('update.payment.status');
    Route::post('/send/photo', [App\Http\Controllers\StudentController::class, 'userProfile'])->name('user.send.photo');
    Route::post('/send/videos', [App\Http\Controllers\UserAdminController::class, 'upload'])->name('admin.upload.video');
    Route::post('/edit/videos', [App\Http\Controllers\UserAdminController::class, 'updateVideoDescription']);
    Route::post('/delete/videos/{id}', [App\Http\Controllers\UserAdminController::class, 'deleteVideos'])->name('admin.delete.video');
    Route::post('/send/thumbnail', [App\Http\Controllers\UserAdminController::class, 'videoThumbnail'])->name('user.send.photo');
});