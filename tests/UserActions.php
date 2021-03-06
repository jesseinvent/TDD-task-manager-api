<?php

namespace Tests;

use App\Models\Task;
use Tests\Helpers\TestsData;

trait UserActions {

    public function attemptUserSignup ()
    {
        $data = new TestsData();
        return  $this->withHeaders([
                'Accept' => 'application/json',
            ])
            ->post('/api/auth/signup', $data->user());
    }

    public function attemptInvalidUserSignup ()
    {
        $data = new TestsData();
        return  $this->withHeaders([
                'Accept' => 'application/json',
            ])
            ->post('/api/auth/signup', array_merge($data->user(), ['name' => '']));
    }

    public function attemptUserLogin ()
    {
        $data = new TestsData();
        return  $this->withHeaders([
                'Accept' => 'application/json',
            ])
                ->post('/api/auth/login', [
                    'email' => $data->user()['email'],
                    'password' => 'password',
                ]);
    }

    public function attemptWrongUserLogin ()
    {
        $data = new TestsData();
        return  $this->withHeaders([
             'Accept' => 'application/json',
            ])
                ->post('/api/auth/login', [
                    'email' => $data->user()['email'],
                    'password' => 'wrong',
                ]);
    }

    public function attemptUserLogout()
    {
        return $this->withHeaders([
                'Accept' => 'application/json',
             ])
             ->post('/api/auth/logout');
    }

    public function attemptToCreateTask($token)
    {
        $data = new TestsData();
        return $this->withHeaders([
                            'Accept' => 'application/json',
                            'Authorization' => 'Bearer '.$token
                        ])
                    ->post('/api/tasks', $data->task()
                );
    }

    public function attemptToUpdateTask($token, array $newTask)
    {
        $data = new TestsData();
        return $this->withHeaders([
                            'Accept' => 'application/json',
                            'Authorization' => 'Bearer '.$token
                        ])
                    ->patch('/api/tasks/'.Task::first()->id, array_merge($data->task(), $newTask));
    }

    public function attemptToDeleteTask($token)
    {
        $data = new TestsData();
        return $this->withHeaders([
                            'Accept' => 'application/json',
                            'Authorization' => 'Bearer '.$token
                        ])
                    ->delete('/api/tasks/'.Task::first()->id);
    }

    public function attemptTo_Mark_Task_AsComplete($token)
    {
        $data = new TestsData();
        return $this->withHeaders([
                            'Accept' => 'application/json',
                            'Authorization' => 'Bearer '.$token
                        ])
                    ->post('/api/tasks/'.Task::first()->id.'/completed', $data->task()
                );
    }


    public function attemptTo_Mark_Task_As_UnComplete($token)
    {
        $data = new TestsData();
        return $this->withHeaders([
                            'Accept' => 'application/json',
                            'Authorization' => 'Bearer '.$token
                        ])
                    ->delete('/api/tasks/'.Task::first()->id.'/completed', $data->task()
                );
    }

    public function attemptTo_Get_completed_Tasks($token)
    {
        return $this->withHeaders([
                            'Accept' => 'application/json',
                            'Authorization' => 'Bearer '.$token
                        ])
                    ->get('/api/tasks/'.Task::first()->id.'/completed');
    }
    

    public function attemptTo_Get_Tasks($token)
    {
        return $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$token
        ])
        ->get('/api/tasks');
    }


    public function Mock_User_SigningUp_And_LoggingIn_Action_With_Token_Returned()
    {
        $response = $this->attemptUserSignup();

        $this->attemptUserLogout();

        return $this->attemptUserLogin();
        
        // return $response;

    }
}