<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Especie;
use App\Models\Raza;
use App\Models\TipoCampana;
use App\Models\TipoProcedimiento;
use App\Models\TipoPublicacion;
use App\Models\VacunaCatalogo;

class CatalogosSeeder extends Seeder
{
    public function run(): void
    {
        // ── Especies y Razas ──────────────────────────────────
        $especiesRazas = [
            'Perro' => [
                'Mestizo', 'Labrador', 'Pastor Alemán', 'Golden Retriever',
                'Bulldog', 'Poodle', 'Chihuahua', 'Rottweiler',
                'Husky Siberiano', 'Boxer', 'Dálmata', 'Shih Tzu',
                'Pitbull', 'Schnauzer', 'Cocker Spaniel', 'Otro',
            ],
            'Gato' => [
                'Mestizo', 'Persa', 'Siamés', 'Angora',
                'Maine Coon', 'Bengalí', 'Ragdoll', 'British Shorthair', 'Otro',
            ],
            'Ave' => [
                'Periquito', 'Canario', 'Loro', 'Cacatúa',
                'Perico', 'Agaporni', 'Otro',
            ],
            'Conejo' => [
                'Holandés', 'Angora', 'Mini Lop', 'Rex', 'Cabeza de León', 'Otro',
            ],
            'Hámster' => [
                'Sirio', 'Ruso', 'Roborovski', 'Chino', 'Otro',
            ],
        ];

        foreach ($especiesRazas as $espNombre => $razas) {
            $especie = Especie::firstOrCreate(
                ['nombre' => $espNombre],
                ['activo' => true]
            );

            foreach ($razas as $razaNombre) {
                Raza::firstOrCreate(
                    ['especie_id' => $especie->id, 'nombre' => $razaNombre],
                    ['activo' => true]
                );
            }
        }

        // ── Tipos de Campaña ──────────────────────────────────
        $tiposCampana = [
            ['nombre' => 'Vacunación',       'descripcion' => 'Campaña de vacunación masiva',        'icono' => '💉'],
            ['nombre' => 'Esterilización',   'descripcion' => 'Campaña de esterilización gratuita',  'icono' => '🏥'],
            ['nombre' => 'Desparasitación',  'descripcion' => 'Campaña de desparasitación',          'icono' => '💊'],
            ['nombre' => 'Adopción',         'descripcion' => 'Feria de adopción responsable',       'icono' => '🐾'],
            ['nombre' => 'Capacitación',     'descripcion' => 'Taller de tenencia responsable',      'icono' => '📚'],
            ['nombre' => 'Censo',            'descripcion' => 'Censo de animales de compañía',       'icono' => '📋'],
        ];
        foreach ($tiposCampana as $tc) {
            TipoCampana::firstOrCreate(['nombre' => $tc['nombre']], $tc);
        }

        // ── Tipos de Procedimiento ────────────────────────────
        $tiposProc = [
            ['nombre' => 'Esterilización',   'descripcion' => 'Cirugía de esterilización/castración', 'requiere_detalle' => false],
            ['nombre' => 'Desparasitación',  'descripcion' => 'Aplicación de desparasitante',         'requiere_detalle' => true],
            ['nombre' => 'Consulta',         'descripcion' => 'Consulta veterinaria general',         'requiere_detalle' => true],
            ['nombre' => 'Cirugía',          'descripcion' => 'Intervención quirúrgica',              'requiere_detalle' => true],
            ['nombre' => 'Tratamiento',      'descripcion' => 'Tratamiento médico continuo',          'requiere_detalle' => true],
            ['nombre' => 'Limpieza Dental',  'descripcion' => 'Profilaxis dental',                    'requiere_detalle' => false],
            ['nombre' => 'Microchip',        'descripcion' => 'Implantación de microchip',            'requiere_detalle' => false],
        ];
        foreach ($tiposProc as $tp) {
            TipoProcedimiento::firstOrCreate(['nombre' => $tp['nombre']], $tp + ['activo' => true]);
        }

        // ── Tipos de Publicación ──────────────────────────────
        $tiposPub = [
            ['nombre' => 'Aviso',      'descripcion' => 'Aviso de animal perdido o encontrado'],
            ['nombre' => 'Noticia',    'descripcion' => 'Noticia institucional'],
            ['nombre' => 'Educación',  'descripcion' => 'Contenido educativo sobre tenencia responsable'],
            ['nombre' => 'Evento',     'descripcion' => 'Información sobre eventos y campañas'],
        ];
        foreach ($tiposPub as $tpub) {
            TipoPublicacion::firstOrCreate(['nombre' => $tpub['nombre']], $tpub + ['activo' => true]);
        }

        // ── Vacunas Catálogo ──────────────────────────────────
        $perroId = Especie::where('nombre', 'Perro')->value('id');
        $gatoId  = Especie::where('nombre', 'Gato')->value('id');

        $vacunas = [
            ['nombre' => 'Antirrábica',           'especie_id' => null,     'descripcion' => 'Vacuna contra la rabia — obligatoria'],
            ['nombre' => 'Parvovirus',            'especie_id' => $perroId, 'descripcion' => 'Vacuna contra parvovirus canino'],
            ['nombre' => 'Moquillo',              'especie_id' => $perroId, 'descripcion' => 'Vacuna contra distemper canino'],
            ['nombre' => 'Séxtuple Canina',       'especie_id' => $perroId, 'descripcion' => 'Vacuna séxtuple (DHLPP+C)'],
            ['nombre' => 'Leptospirosis',         'especie_id' => $perroId, 'descripcion' => 'Vacuna contra leptospirosis'],
            ['nombre' => 'Triple Felina',         'especie_id' => $gatoId,  'descripcion' => 'Rinotraqueitis, calicivirus, panleucopenia'],
            ['nombre' => 'Leucemia Felina',       'especie_id' => $gatoId,  'descripcion' => 'Vacuna contra FeLV'],
        ];
        foreach ($vacunas as $v) {
            VacunaCatalogo::firstOrCreate(['nombre' => $v['nombre']], $v + ['activo' => true]);
        }
    }
}
