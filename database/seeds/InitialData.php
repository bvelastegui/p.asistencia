<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InitialData extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createUsers();
        $this->createCourses();
        $this->createSubjects();
        $this->createStudents();
        DB::table('schedules')->insert([
            ['subject_id' => 1, 'start' => '16:00', 'end' => '19:00', 'day' => 'Monday'],
            ['subject_id' => 2, 'start' => '19:00', 'end' => '21:00', 'day' => 'Monday'],
            ['subject_id' => 3, 'start' => '16:00', 'end' => '18:00', 'day' => 'Tuesday'],
            ['subject_id' => 4, 'start' => '18:00', 'end' => '20:00', 'day' => 'Tuesday'],
            ['subject_id' => 5, 'start' => '20:00', 'end' => '21:00', 'day' => 'Tuesday'],
        ]);
    }

    protected function createUsers(): void
    {
        $password = '$2y$10$3ew0.Mw5Z2wL7/cEp/kopeiTsX.Ysbdf.dIuhhX4OaMRnTZylqBBi';

        DB::table('users')->insert([
            ['id' => 3, 'name' => 'Fernando Jacome', 'identity' => '1234567891', 'email' => 'fjacome@intitec.com', 'is_admin' => false, 'password' => $password],
            ['id' => 4, 'name' => 'Darwin Duque', 'identity' => '1234567892', 'email' => 'dduque@intitec.com', 'is_admin' => false, 'password' => $password],
            ['id' => 5, 'name' => 'Edison Guaman', 'identity' => '1234567893', 'email' => 'eguaman@intitec.com', 'is_admin' => false, 'password' => $password],
            ['id' => 6, 'name' => 'Alfonso Andrade', 'identity' => '1234567894', 'email' => 'aandrade@intitec.com', 'is_admin' => true, 'password' => $password],
            ['id' => 7, 'name' => 'Flavio Pachacama', 'identity' => '1234567895', 'email' => 'fpachacama@intitec.com', 'is_admin' => false, 'password' => $password]
        ]);
    }

    protected function createCourses(): void
    {
        DB::table('courses')->insert([
            ['id' => 1, 'name' => 'Electrónica de Procesos Industriales', 'level' => 'Quinto nivel', 'code' => '5TO EPI'],
            ['id' => 2, 'name' => 'Electrónica de procesos industriales', 'level' => 'Sexto nivel', 'code' => '6TO EPI'],
            ['id' => 3, 'name' => 'Informática y Programación de Gestión', 'level' => 'Quinto nivel', 'code' => '5TO IPG']
        ]);
    }

    protected function createSubjects(): void
    {
        DB::table('subjects')->insert([
            ['id' => 1, 'course_id' => 1, 'name' => 'Automatización con micros', 'user_id' => 3],
            ['id' => 2, 'course_id' => 1, 'name' => 'Gestión empresarial', 'user_id' => 6],
            ['id' => 3, 'course_id' => 1, 'name' => 'Taller de trabajo de titulación', 'user_id' => 7],
            ['id' => 4, 'course_id' => 1, 'name' => 'Desarrollo de proyectos informáticos', 'user_id' => 4],
            ['id' => 5, 'course_id' => 1, 'name' => 'Instrumentación industrial', 'user_id' => 7],
            ['id' => 6, 'course_id' => 1, 'name' => 'Seguridad y mantenimiento industrial', 'user_id' => 7],
            ['id' => 7, 'course_id' => 1, 'name' => 'Ética y responsabilidad social', 'user_id' => 6],
            ['id' => 8, 'course_id' => 1, 'name' => 'Ingles V', 'user_id' => 6],
            ['id' => 9, 'course_id' => 2, 'name' => 'Herramientas CAD', 'user_id' => 5],
            ['id' => 10, 'course_id' => 2, 'name' => 'Ingles VI', 'user_id' => 3],
            ['id' => 12, 'course_id' => 2, 'name' => 'Controladores lógicos programables', 'user_id' => 3],
            ['id' => 13, 'course_id' => 2, 'name' => 'Control automático II', 'user_id' => 3],
            ['id' => 14, 'course_id' => 3, 'name' => 'Redes y comunicaciones de datos', 'user_id' => 4],
            ['id' => 15, 'course_id' => 3, 'name' => 'Ingeniería de software', 'user_id' => 4],
            ['id' => 16, 'course_id' => 3, 'name' => 'Ética y responsabilidad social', 'user_id' => 6],
            ['id' => 17, 'course_id' => 3, 'name' => 'Ingles V', 'user_id' => 6],
        ]);
    }

    protected function createStudents(): void
    {
        DB::table('students')->insert([
            ['name' => 'Jonathan René', 'last_name' => 'Acero Chicaiza', 'course_id' => 1,],
            ['name' => 'Helmer Hernán', 'last_name' => 'Agama Zapata', 'course_id' => 1,],
            ['name' => 'Iván Fernando', 'last_name' => 'Guilcamaygua Imbaquingo', 'course_id' => 1,],
            ['name' => 'Bryan Paúl', 'last_name' => 'Llumiquinga Tello', 'course_id' => 1,],
            ['name' => 'José Iván', 'last_name' => 'Moreno Vicente', 'course_id' => 1,],
            ['name' => 'Héctor Josué', 'last_name' => 'Pavón Coque', 'course_id' => 1,],
            ['name' => 'Alfredo Alexander', 'last_name' => 'Pusdá Ger', 'course_id' => 1,],
            ['name' => 'Nicole Mishell', 'last_name' => 'Salazar Remache', 'course_id' => 1,],
            ['name' => 'Jorge Roberto', 'last_name' => 'Tenorio Tercero', 'course_id' => 1,],
            ['name' => 'Carmen Susana', 'last_name' => 'Ushiña Tashiguano', 'course_id' => 1,],
            ['name' => 'Naelson Oswaldo', 'last_name' => 'Chuquitarco Allauca', 'course_id' => 1,],
            ['name' => 'Luis Eduardo', 'last_name' => 'Mendoza Gagñay', 'course_id' => 1,],
            ['name' => 'Henry Duglas', 'last_name' => 'Toala Arreaga', 'course_id' => 1,],
            ['name' => 'Jorge Ramiro', 'last_name' => 'Guamaní Cuvi', 'course_id' => 2,],
            ['name' => 'Luis Alberto', 'last_name' => 'Mero Mero', 'course_id' => 2,],
            ['name' => 'Rodolfo Javier', 'last_name' => 'Miranda Condoy', 'course_id' => 2,],
            ['name' => 'Óscar Javier', 'last_name' => 'Pozo Chávez', 'course_id' => 2,],
            ['name' => 'Jessenia Michell', 'last_name' => 'Quiguango Cando', 'course_id' => 2,],
            ['name' => 'Santiago Xavier', 'last_name' => 'Chanaluisa Zhicay', 'course_id' => 3,],
            ['name' => 'Ewin Ismael', 'last_name' => 'Encalada Hidalgo', 'course_id' => 3,],
            ['name' => 'Erick Alexander', 'last_name' => 'Freire Collaguazo', 'course_id' => 3,],
            ['name' => 'John Dario', 'last_name' => 'Llive Cupacán', 'course_id' => 3,],
            ['name' => 'Jack Michael', 'last_name' => 'Menéndez Balseca', 'course_id' => 3,],
            ['name' => 'Ginger Antonella', 'last_name' => 'Orquera Padilla', 'course_id' => 3,],
            ['name' => 'Katherine Dayan', 'last_name' => 'Quishpe Collaguazo', 'course_id' => 3,],
        ]);
    }
}
