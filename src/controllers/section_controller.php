<?php

namespace Controller;

class SectionController extends \Configs\Controller
{
  public function get_students($request, $response, $args) {
    $section_id = $request->getParam('section_id');
    $teacher_id = $_SESSION['teacher_id'];
    $rpta = [];
    $status = 200;
    \ORM::get_db('app')->beginTransaction();
    try {
      $students = \Model::factory('\Models\VWStudentSection', 'app')
        ->select('student_code', 'code')
        ->select('student_name', 'name')
        ->select('tw_id')
        ->select('tw_pass')
        ->where('section_id', $section_id)
        ->where('teacher_id', $teacher_id)
        ->find_array();
      $rpta = $students;
      \ORM::get_db('app')->commit();
    }catch (Exception $e) {
      $status = 500;
      $rpta = [
        'Se ha producido un error en listar los alumnos de la sección seleccionada',
        $e->getMessage()
      ];
      \ORM::get_db('app')->rollBack();
    }
    return $response->withStatus($status)->write(json_encode($rpta));
  }
}
