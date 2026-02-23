<?php

namespace Database\Seeders;

use App\Models\CredencialEmpleado;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $userJuan = User::create([
            'curp' => 'JUAP850101HDFLRS01',
            'nombre' => 'Juan',
            'apellido_paterno' => 'Pérez',
            'apellido_materno' => 'Ramírez',
            'sexo' => 'Masculino',
            'fecha_nacimiento' => '1985-01-01',
            'email' => 'juan.perez@hospital.com',
            'password' => Hash::make('password123'),
            'telefono' => '7774441234',
        ]);

        $userJuan->colaborador_responsable_id = $userJuan->id;
        $userJuan->save();

        $userMaria = User::create([
            'curp' => 'MALO900214MDFLPS02',
            'nombre' => 'María',
            'apellido_paterno' => 'López',
            'apellido_materno' => 'Santos',
            'sexo' => 'Femenino',
            'fecha_nacimiento' => '1990-02-14',
            'email' => 'enfermeralicenciada@hospital.com',
            'telefono' => '7774441234',
            'colaborador_responsable_id' => $userJuan->id, 
            'password' => Hash::make('password123'),
        ]);
        CredencialEmpleado::create([
            'user_id' => $userMaria->id,
            'titulo' => 'Licenciatura en Enfermería',
            'cedula_profesional' => '7654321'
        ]);

        $userCarlos = User::create([
            'curp' => 'CARA820710HDFRMR03',
            'nombre' => 'Carlos',
            'apellido_paterno' => 'Ramírez',
            'apellido_materno' => 'Moreno',
            'sexo' => 'Masculino',
            'fecha_nacimiento' => '1982-07-10',
            'colaborador_responsable_id' => $userJuan->id,
            'telefono' => '7774441234', 
            'email' => 'enfermeraauxiliar@test.com',
            'password' => Hash::make('12345678'),
        ]);

        $userCarlos->assignRole('enfermera(o)');

       
        User::create([
            'curp' => 'LAHE880320MDFHND04',
            'nombre' => 'Laura',
            'apellido_paterno' => 'Hernández',
            'apellido_materno' => 'Díaz',
            'sexo' => 'Femenino',
            'fecha_nacimiento' => '1988-03-20',
            'colaborador_responsable_id' => $userCarlos->id,
            'telefono' => '7774441234', 
            'email' => 'laura.hernandez@hospital.com',
            'password' => Hash::make('password123'),
        ]);

        $userAndres = User::create([
            'curp' => 'ANGG910923HDFGLZ05',
            'nombre' => 'Andrés',
            'apellido_paterno' => 'González',
            'apellido_materno' => 'Luna',
            'sexo' => 'Masculino',
            'fecha_nacimiento' => '1991-09-23',
            'colaborador_responsable_id' => $userMaria->id,
            'telefono' => '7774441234', 
            'email' => 'andres.gonzalez@hospital.com',
            'password' => Hash::make('password123'),
        ]);

        $user = User::create([
            'curp' => 'SOMA950105MDFMRT06',
            'nombre' => 'Sofía',
            'apellido_paterno' => 'Martínez',
            'apellido_materno' => 'Rojas',
            'sexo' => 'Femenino',
            'fecha_nacimiento' => '1995-01-05',
            'colaborador_responsable_id' => $userAndres->id,
            'telefono' => '7774441234', 
            'email' => 'sofia.martinez@hospital.com',
            'password' => Hash::make('password123'),
        ]);

        CredencialEmpleado::create([
            'user_id' => $user->id,
            'titulo' => 'Médico Especialista en Cirugía General',
            'cedula_profesional' => '9123456' 
        ]);

        CredencialEmpleado::create([
            'user_id' => $user->id,
            'titulo' => 'Médico Especialista en Pediatría',
            'cedula_profesional' => '8765432'
        ]);

        $user = User::create([
            'curp' => 'TIMK040210HMSRDVA6',
            'nombre' => 'Kevin Yahir',
            'apellido_paterno' => 'Trinidad',
            'apellido_materno' => 'Medina',
            'sexo' => 'Masculino', 
            'fecha_nacimiento' => '2004-02-10',
            'email' => 'kevinyahirt@gmail.com',
            'telefono' => '7774441234',
            'password' => Hash::make('12345678'),
        ]);

        $user->assignRole('administrador');

        $user = User::create([
            'curp' => 'HEAL000101HDFXXX01', 
            'nombre' => 'HealthCare',
            'apellido_paterno' => 'Prueba',
            'apellido_materno' => 'Sistema',
            'sexo' => 'Masculino', 
            'fecha_nacimiento' => '2000-01-01',
            'email' => 'healthcare@test.com',
            'telefono' => '7774441234',
            'password' => Hash::make('12345678'),
        ]);

        $user->assignRole('administrador');

         $user = User::create([
            'curp' => 'HEGE040302HMSRMFA0',
            'nombre' => 'Efrain',
            'apellido_paterno' => 'Hernández',
            'apellido_materno' => 'Gómez',
            'sexo' => 'Masculino', 
            'fecha_nacimiento' => '2004-03-02',
            'email' => 'efrainhdz@gmail.com',
            'telefono' => '7774441234',
            'password' => Hash::make('12345678'),
        ]);

        $user->assignRole('administrador');
        
        CredencialEmpleado::create([
            'user_id' => $user->id,
            'titulo' => 'Médico Especialista en Pediatría',
            'cedula_profesional' => '8765432'
        ]);

        $user = User::create([
            'curp' => 'HEGE040302HMRMFA2',
            'nombre' => 'Efrain ',
            'apellido_paterno' => 'Hernández',
            'apellido_materno' => 'Gómez',
            'sexo' => 'Masculino', 
            'fecha_nacimiento' => '2004-03-02',
            'email' => 'farmacia@test.com',
            'telefono' => '7774441234',
            'password' => Hash::make('12345678'),
        ]);

        $user->assignRole('farmacia');

        $userRecepcion = User::create([
            'curp' => 'PESA950615MDFRNS03',
            'nombre' => 'Ana María',
            'apellido_paterno' => 'Pérez',
            'apellido_materno' => 'Sánchez',
            'sexo' => 'Femenino',
            'fecha_nacimiento' => '1995-06-15',
            'email' => 'recepcion@test.com',
            'telefono' => '7774441234',
            'password' => Hash::make('12345678'),
        ]);

        $userRecepcion->assignRole('recepcion');

        $userCaja = User::create([
            'curp' => 'GOLO900101HDFRNS05',
            'nombre' => 'Carlos',
            'apellido_paterno' => 'Gómez',
            'apellido_materno' => 'López',
            'sexo' => 'Masculino',
            'fecha_nacimiento' => '1990-01-01',
            'email' => 'caja@test.com',
            'telefono' => '7774441234',
            'password' => Hash::make('12345678'),
        ]);

        $userCaja->assignRole('caja');      
        
        $userLaboratorio = User::create([
            'curp' => 'TORA920515MDFRRN01',
            'nombre' => 'Ana',
            'apellido_paterno' => 'Torres',
            'apellido_materno' => 'Ruiz',
            'sexo' => 'Femenino',
            'fecha_nacimiento' => '1992-05-15',
            'telefono' => '7774441234',
            'email' => 'tmko220776@upemor.edu.mx',
            'password' => Hash::make('12345678'),
        ]);

        $userLaboratorio->assignRole('técnico de laboratorio');

        // 1. Dr Juan Manuel Ahumada Trujillo
        $userJuan = User::create([
            'curp' => 'AHTJ800101HDFRRN02', 
            'nombre' => 'Juan Manuel',
            'apellido_paterno' => 'Ahumada',
            'apellido_materno' => 'Trujillo',
            'sexo' => 'Masculino',
            'fecha_nacimiento' => '1980-01-01',
            'telefono' => '7771002030',
            'email' => 'juan.ahumada@test.com',
            'password' => Hash::make('12345678'),
        ]);

        $userJuan->assignRole('medico especialista');

        // 2. Dr Fidel Humberto Ortiz Espinoza
        $userFidel = User::create([
            'curp' => 'OIEF820520HDFRRN03', 
            'nombre' => 'Fidel Humberto',
            'apellido_paterno' => 'Ortiz',
            'apellido_materno' => 'Espinoza',
            'sexo' => 'Masculino',
            'fecha_nacimiento' => '1982-05-20',
            'telefono' => '7772003040',
            'email' => 'fidel.ortiz@test.com',
            'password' => Hash::make('12345678'),
        ]);

        $userFidel->assignRole('medico especialista');

        // 3. Dr Carlos Gabriel Juarez Tapia
        $userCarlos = User::create([
            'curp' => 'JUTC850815HDFRRN04', 
            'nombre' => 'Carlos Gabriel',
            'apellido_paterno' => 'Juarez',
            'apellido_materno' => 'Tapia',
            'sexo' => 'Masculino',
            'fecha_nacimiento' => '1985-08-15',
            'telefono' => '7773004050',
            'email' => 'carlos.juarez@test.com',
            'password' => Hash::make('12345678'),
        ]);

        $userCarlos->assignRole('medico especialista');

        // 4. Técnica Luz Morales
        $userLuz = User::create([
            'curp' => 'MOLX900210MDFRRN05', 
            'nombre' => 'Luz',
            'apellido_paterno' => 'Morales',
            'apellido_materno' => '',
            'sexo' => 'Femenino',
            'fecha_nacimiento' => '1990-02-10',
            'telefono' => '7774005060',
            'email' => 'luz.morales@test.com',
            'password' => Hash::make('12345678'),
        ]);

        $userLuz->assignRole('enfermera(o)');

        // 5. Lic America Jaimes Barcenas
        $userAmerica = User::create([
            'curp' => 'JABA930725MDFRRN06', 
            'nombre' => 'America',
            'apellido_paterno' => 'Jaimes',
            'apellido_materno' => 'Barcenas',
            'sexo' => 'Femenino',
            'fecha_nacimiento' => '1993-07-25',
            'telefono' => '7775006070',
            'email' => 'america.jaimes@test.com',
            'password' => Hash::make('12345678'),
        ]);

        $userAmerica->assignRole('administrador');

        // 6. Josué Ortiz López 
        $userJosue = User::create([
            'curp' => 'OILJ951130HDFRRN07',
            'nombre' => 'Josué',
            'apellido_paterno' => 'Ortiz',
            'apellido_materno' => 'López',
            'sexo' => 'Masculino',
            'fecha_nacimiento' => '1995-11-30',
            'telefono' => '7776007080',
            'email' => 'josue.ortiz@test.com',
            'password' => Hash::make('12345678'),
        ]);

        $userJosue->assignRole('administrador');

        $userErika = User::create([
            'curp' => 'FORE900101MDFRRN01', 
            'nombre' => 'Erika',
            'apellido_paterno' => 'Flores',
            'apellido_materno' => 'Rodriguez',
            'sexo' => 'Femenino',
            'fecha_nacimiento' => '1990-01-01', 
            'telefono' => '7772329969',
            'email' => 'erika.flores@test.com',
            'password' => Hash::make('12345678'),
        ]);

        $userErika->assignRole('medico');

        $userAzamar = User::create([
            'curp' => 'VARA920202HDFRRN02', 
            'nombre' => 'Azamar Aaron',
            'apellido_paterno' => 'Vargas',
            'apellido_materno' => 'Radilla',
            'sexo' => 'Masculino',
            'fecha_nacimiento' => '1992-02-02', 
            'telefono' => '7774608751',
            'email' => 'azamar.vargas@test.com',
            'password' => Hash::make('12345678'),
        ]);

        $userAzamar->assignRole('medico');

        $userDiego = User::create([
            'curp' => 'EABD950303HDFRRN03', 
            'nombre' => 'Diego Enrique',
            'apellido_paterno' => 'Erazo',
            'apellido_materno' => 'Barreto',
            'sexo' => 'Masculino',
            'fecha_nacimiento' => '1995-03-03', 
            'telefono' => '7773895596',
            'email' => 'diego.erazo@test.com',
            'password' => Hash::make('12345678'),
        ]);

        $userDiego->assignRole('medico');

        $userRodolfo = User::create([
            'curp' => 'PEGR880404HDFRRN04', 
            'nombre' => 'Rodolfo',
            'apellido_paterno' => 'Pérez',
            'apellido_materno' => 'Gutiérrez',
            'sexo' => 'Masculino',
            'fecha_nacimiento' => '1988-04-04', 
            'telefono' => '7772583877',
            'email' => 'rodolfo.perez@test.com',
            'password' => Hash::make('12345678'),
        ]);

        $userRodolfo->assignRole('medico');

        $userGabriel = User::create([
            'curp' => 'GAGL900101HDFRNS05', 
            'nombre' => 'Gabriel',
            'apellido_paterno' => 'Gómez',
            'apellido_materno' => 'López',
            'sexo' => 'Masculino',
            'fecha_nacimiento' => '1990-01-01',
            'email' => 'gabriel@test.com', 
            'telefono' => '7774441234',
            'password' => Hash::make('12345678'),
        ]);

        $userGabriel->assignRole('caja');

        $userCocina = User::create([
            'curp' => 'ROMA850512MDFRNS08', 
            'nombre' => 'Rosa',
            'apellido_paterno' => 'Martínez',
            'apellido_materno' => 'Aguirre',
            'sexo' => 'Femenino',
            'fecha_nacimiento' => '1985-05-12',
            'email' => 'cocina@test.com', 
            'telefono' => '7775556789',
            'password' => Hash::make('12345678'),
        ]);

        $userCocina->assignRole('cocina');

        $userRadiologo = User::create([
            'curp' => 'GOLJ900325HDFLNR05', 
            'nombre' => 'Jorge',
            'apellido_paterno' => 'Gómez',
            'apellido_materno' => 'López',
            'sexo' => 'Masculino',
            'fecha_nacimiento' => '1990-03-25',
            'email' => 'radiologo@test.com', 
            'telefono' => '7771234567',
            'password' => Hash::make('12345678'),
        ]);

        $userRadiologo->assignRole('radiólogo');

        $userRadiologo = User::create([
            'curp' => 'GURJ990310HMSTBS01', 
            'nombre' => 'Josue Israel',
            'apellido_paterno' => 'Gutierrez',
            'apellido_materno' => 'Robles',
            'sexo' => 'Masculino',
            'fecha_nacimiento' => '1999-03-10',
            'email' => 'gtzjosuerobles@hotmail.com', 
            'telefono' => '7772342396',
            'password' => Hash::make('12345678'), 
        ]);

        $userRadiologo->assignRole('radiólogo');

    }
}
