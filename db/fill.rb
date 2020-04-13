# encoding: utf-8
require 'sequel'

Sequel::Model.plugin :json_serializer

DB = Sequel.connect('sqlite://app.db')

class Student < Sequel::Model(DB[:students])

end

class Section < Sequel::Model(DB[:sections])
  
end

class SectionStudent < Sequel::Model(DB[:sections_students])
  
end

def fill_students
  # todos menos los de la sede central - San Isidro
  f = File.open('./data/pepe.txt', :encoding => 'UTF-8')
  DB.transaction do
    begin
      f.each_line do |line|
        # puts line
        array = line.split('::')
        student_code = array[0]
        section_id = array[1].strip
        # save student
        student = Student.new(
          :code => student_code,
          :name => '',
          :email => student_code + '@aloe.ulima.edu.pe',
          :picture => '',
          :tw_id => '',
          :tw_pass => '',
        )
        student.save
        # save student in section
        section_student = SectionStudent.new(
          :section_id => section_id,
          :student_id => student.id,
        )
        section_student.save
      end
      f.close
    rescue Exception => e
      Sequel::Rollback
      puts 'error!'
      puts e.message
      puts e.backtrace
    end
  end
end

# fill_students
def add_name_students
  # todos menos los de la sede central - San Isidro
  f = File.open('./data/pepe2.txt', :encoding => 'UTF-8')
  DB.transaction do
    begin
      f.each_line do |line|
        # puts line
        array = line.split('::')
        student_code = array[0]
        student_name = array[1]
        student_lastname = array[2].strip
        # update student
        puts student_code
        student = Student.where(
          :code => student_code
        ).first
        if(student != nil)
          student.name = student_lastname + ', ' + student_name
          student.save
        end
      end
      f.close
    rescue Exception => e
      Sequel::Rollback
      puts 'error!'
      puts e.message
      puts e.backtrace
    end
  end
end

def fill_students_checking_repetead(file_name)
  # todos menos los de la sede central - San Isidro
  f = File.open('./data/' + file_name, :encoding => 'UTF-8')
  DB.transaction do
    begin
      f.each_line do |line|
        # puts line
        array = line.split('::')
        student_code = array[0]
        student_name = array[1].strip
        # checking_repetead
        count = Student.where(
          :code => student_code,
        ).count()
        if count == 0
          # save student if not exist
          student = Student.new(
            :code => student_code,
            :name => student_name,
            :email => student_code + '@aloe.ulima.edu.pe',
            :picture => 'https://i.stack.imgur.com/ZQT8Z.png',
            :tw_id => '',
            :tw_pass => '',
          )
          student.save
        end 
      end
      f.close
    rescue Exception => e
      Sequel::Rollback
      puts 'error!'
      puts e.message
      puts e.backtrace
    end
  end
end

def fill_students_section(file_name)
  # todos menos los de la sede central - San Isidro
  f = File.open('./data/' + file_name, :encoding => 'UTF-8')
  DB.transaction do
    begin
      f.each_line do |line|
        # puts line
        array = line.split('::')
        student_code = array[0]
        section_id = array[1].strip
        # checking_if student exist
        student = Student.where(
          :code => student_code,
        ).first
        if student != nil
          # check if student not registered in section
          count = SectionStudent.where(
            :section_id => section_id,
            :student_id => student.id,
          ).count()
          if count == 0
            # save student in section
            section_student = SectionStudent.new(
              :section_id => section_id,
              :student_id => student.id,
            )
            section_student.save
          end
        else 
          puts student_code.to_s + ' no exist as student'
        end
      end
      f.close
    rescue Exception => e
      Sequel::Rollback
      puts 'error!'
      puts e.message
      puts e.backtrace
    end
  end
end

# fill_students_checking_repetead('irey.txt')
fill_students_section('irey_students_secction.txt')