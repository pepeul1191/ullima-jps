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
        ->select('student_id', 'student_id')
        ->select('student_code', 'code')
        ->select('student_name', 'name')
        ->select('section_id')
        ->select('tw_id')
        ->select('tw_pass')
        ->select('points')
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

  public function update_student_points($request, $response, $args) {
    $section_id = $request->getParam('section_id');
    $student_id = $request->getParam('student_id');
    $operation = $request->getParam('operation');
    $rpta = [];
    $status = 200;
    \ORM::get_db('app')->beginTransaction();
    try {
      $student_section = \Model::factory('\Models\SectionStudent', 'app')
        ->where('section_id', $section_id)
        ->where('student_id', $student_id)
        ->find_one();
      if($student_section->points == null){
        $student_section->points = 0;
      }
      // operations
      if($operation == 'remove'){
        if($student_section->points > 0){
          $student_section->points = $student_section->points - 1;
        }
      }else{
        $student_section->points = $student_section->points + 1;
      }
      $student_section->save();
      \ORM::get_db('app')->commit();
      $rpta = intval($student_section->points);
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
