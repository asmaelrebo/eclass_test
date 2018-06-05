<?php 

class TeacherSchedulesController extends \AppController {

	public function save_add() {
		$idClient = \CigarrilloBuilder::get('idClient');
		$teachers = $this->TeacherSchedule->Person->find('list', [
			'fields' => ['id', 'nombre_completo'],
			'conditions' => ['clases_virtuales' => 1, 'id_cliente' => $idClient],
			'order' => 'nombre_completo ASC'
		]);

		$data = $this->request->input('json_decode', true);

		$errorCode = '';
		$unitVenues = [];

		if (!empty($data)) {
			$dataSource = $this->TeacherSchedule->getDataSource();
			$dataSource->begin();
			$error = false;
			$days = [];
			$teacherSchedule = $data['TeacherSchedule'];

			if ($teacherSchedule['fecha_inicio'] != '') {

				/**
				 *  Obtiene el campo fecha_inicio ya que guardará un horario especifico en la agenda
				 * 	Obtiene validInit en base a la separación de fecha_inicio
				 *	Si la fecha_inicio es menor que hoy validInit cambia a false
				 */
				$initParts = explode('-', $teacherSchedule['fecha_inicio']);
				$validInit = checkdate($initParts[1], $initParts[2], $initParts[0]);
				if ($teacherSchedule['fecha_inicio'] < date('Y-m-d')) {
					$validInit = false;
				}
				/** Fin explicación **/

				if ($validInit) {
					$saveType = 1;
					$days[] = $teacherSchedule['fecha_inicio'];
					if ($teacherSchedule['fecha_fin'] != '') {

						$endParts = explode('-', $teacherSchedule['fecha_fin']);
						$validEnd = checkdate($endParts[1], $endParts[2], $endParts[0]);
						if ($teacherSchedule['fecha_fin'] < date('Y-m-d')) {
							$validEnd = false;
						}

						if ($validEnd) {

							/**
							 *  Compara que la fecha_inicio sea menor o igual que la fecha_fin, 
							 *	si es menor obtiene cada día siguiente correspondiente entre la fecha_inicio y fecha_fin y lo agrega a days, incluye el día de la fecha_inicio
							 *	si la fecha_inicio es mayor a la fecha_fin se asigna la variable error
							 */
							if ($teacherSchedule['fecha_inicio'] <= $teacherSchedule['fecha_fin']) {

								$currentDay = $teacherSchedule['fecha_inicio'];
								while ($currentDay != $teacherSchedule['fecha_fin']) {
									$currentDay = date('Y-m-d', strtotime('next day', strtotime($currentDay)));
									$days[] = $currentDay;
								}
							}
							else {
								$error = __('Error: La fecha de fin es anterior a la fecha de inicio');
							}
							/** Fin explicación **/
						}
						else {
							$error = __('Error: La fecha de fin es inválida');
						}
					}
				}
				else {
					$error = __('Error: La fecha de inicio es inválida');
				}

			} else if (!empty($teacherSchedule['dias_semana'])) {
				$saveType = 2; //Guarda días
				$days = $teacherSchedule['dias_semana'];
				if (count(array_diff($days, [1, 2, 3, 4, 5, 6, 7])) > 0) {
					$error = __('Error: Los días no son válidos');
				}
			}
			else {
				$error = __('Debe seleccionar un día de semana o una fecha');
			}

			if ($teacherSchedule['disponible'] == 0 && !$error) {
				

				if ($saveType == 1) {

					/**
					 *  Obtiene todos los registros desde el modelo MemberUnitVenue que representa a la tabla alumnos_cursos_clases_sedes donde haya agendado el profesor, según los dias obtenidos anteriormente y que el estado sea 0 o 1, también trae su información relacionada del modelo Member que representa a la tabla alumnos_cursos
					 */
					$memberUnitVenues = $this->TeacherSchedule->Person->Member->MemberUnitVenue->find('all', [
						'conditions' => [
							'fecha' => $days,
							'Member.id_persona' => $teacherSchedule['id_persona'],
							'estado' => [0, 1]
						],
						'contain' => [
							'Member'
						]
					]);
					/** Fin explicación **/

				} else {
					
					/**
					 *  Obtiene todos los registros desde el modelo MemberUnitVenue que representa a la tabla alumnos_cursos_clases_sedes donde haya agendado el profesor, según las siguientes condiciones:
					 - que tengan una fecha agendada mayor al día actual, 
					 - Que el número de día de la semana de fecha + 1 sea igual al dia obtenido de dias_semana de teacherSchedule (el weekday obtiene del 1 al 7 dependiendo del día.)
					 - que el estado sea 0 o 1
					 - que el registro este relacionado al profesor a buscar
					 También trae su información relacionada del modelo Member que representa a la tabla alumnos_cursos
					 */
					$memberUnitVenues = $this->TeacherSchedule->Person->Member->MemberUnitVenue->find('all', [
						'conditions' => [
							'fecha >=' => date('Y-m-d'),
							'weekday(fecha)+1' => $days,
							'Member.id_persona' => $teacherSchedule['id_persona'],
							'estado' => [0, 1]
						],
						'contain' => [
							'Member'
						]
					]);
					/** Fin explicación **/
				}

				if (!$error) {
					$init = date('H:i', strtotime($teacherSchedule['hora_inicio']));
					$end = date('H:i', strtotime($teacherSchedule['hora_fin']));

					//En tres casos una clase topa con un bloque
					foreach ($memberUnitVenues as $memberUnitVenue) {
						$id = $memberUnitVenue['MemberUnitVenue']['id'];
						$memberInit = date('H:i', strtotime($memberUnitVenue['MemberUnitVenue']['hora_inicio']));
						$memberEnd = date('H:i', strtotime($memberUnitVenue['MemberUnitVenue']['hora_fin']));

						//caso 1: clase empieza dentro del bloque
						if ($memberInit >= $init && $memberInit < $end) {
							$unitVenues[$id] = $id;
						}
						//caso 2: clase termina dentro del bloque
						if ($memberEnd > $init && $memberEnd <= $end) {
							$unitVenues[$id] = $id;
						}
						//caso 3: clase empieza antesd el bloque y termina después del bloque
						if ($memberInit <= $init && $memberEnd >= $end) {
							$unitVenues[$id] = $id;
						}
					}

					/**
					 *  Si esta vacio mantener_clases realiza una validación de tope de horario para el profesor
					 */
					if (empty($teacherSchedule['mantener_clases'])) {
						if (count($unitVenues) > 1) {
							$error = __('El profesor tiene varias clases agendadas dentro del horario');
							$errorCode = 'MC01';
						}
						if (count($unitVenues) == 1) {
							$error = __('El profesor tiene una clase agendada dentro del horario');
							$errorCode = 'MC02';
						}
					}
					/** Fin explicación **/
				}
			}

			if ($saveType == 2) {
				
				/**
				 *  Obtiene un arraylist (id => fecha), según los siguientes criterios:
				 *	- que tengan una fecha agendada mayor al día actual, 
				 *	- Que el número de día de la semana de fecha + 1 sea igual al dia obtenido de dias_semana de teacherSchedule (el weekday obtiene del 1 al 7 dependiendo del día.)
				 *	- que el registro este relacionado al profesor a buscar
				 *	- que la disponibilidad sea distinta a lo recibido
				 *	El resultado se agrupa por fecha
				 */
				$nextDays = $this->TeacherSchedule->find('list', [
					'fields' => ['id', 'fecha'],
					'conditions' => [
						'fecha >=' => date('Y-m-d'),
						'weekday(fecha)+1' => $days,
						'id_persona' => $teacherSchedule['id_persona'],
						'disponible !=' => $teacherSchedule['disponible']
					],
					'group' => 'fecha'
				]);
				/** Fin explicación **/

				if (!empty($nextDays)) {
					foreach ($nextDays as $id => $nextDay) {
						//guardar un registro de horario con fecha para el profesor
						$teacherSchedule['dia_semana'] = 0;
						$teacherSchedule['fecha'] = $nextDay;
						//crea horario de profesor
						$this->TeacherSchedule->id = $id;
						if (!$this->TeacherSchedule->save($teacherSchedule)) {
							$error = true;
						}
					}
				}
			}

		}
		else {
			$error = __('No se recibieron datos');
		}

		$response = [
			'error' => $error,
			'errorCode' => $errorCode,
			'unitVenues' => $unitVenues
		];

		$code = empty($error) ? 200 : 400;
		$this->set(compact('code', 'response'));
		$this->set('_serialize', ['code', 'response']);
	}

}

?>