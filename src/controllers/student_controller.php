<?php

namespace Controller;

class StudentController extends \Configs\Controller
{
  public function update_teamviewer($request, $response, $args) {
    $id = $request->getParam('id');
    $tw_id = $request->getParam('tw_id');
    $tw_pass = $request->getParam('tw_pass');
    $rpta = [];
    $status = 200;
    \ORM::get_db('app')->beginTransaction();
    try {
      $student = \Model::factory('\Models\Student', 'app')->find_one($id);
      $student->tw_id = $tw_id;
      $student->tw_pass = $tw_pass;
      $student->save();
      $rpta = [
        'Se ha actualizado los datos de acceso de teamviewer del alumno',
      ];
      \ORM::get_db('app')->commit();
    }catch (Exception $e) {
      $status = 500;
      $rpta = [
        'Se ha producido un error en guardar la tabla de departamentos',
        $e->getMessage()
      ];
      \ORM::get_db('app')->rollBack();
    }
    return $response->withStatus($status)->write(json_encode($rpta));
  }
}
