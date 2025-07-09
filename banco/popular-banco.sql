USE sistema_clinica;

-- Criação de usuários para médicos
INSERT INTO usuarios (username, password) VALUES
('alexandre_med', '$2y$10$dMEM0XJ6xijr7r0G7OpYWOkNEjmJ.5Uvh0MJiS2GVmDZGoK8PMYD2'),
('gustavo_med', '$2y$10$dMEM0XJ6xijr7r0G7OpYWOkNEjmJ.5Uvh0MJiS2GVmDZGoK8PMYD2'),
('allan_med', '$2y$10$dMEM0XJ6xijr7r0G7OpYWOkNEjmJ.5Uvh0MJiS2GVmDZGoK8PMYD2');

-- Criação de médicos
INSERT INTO medicos (nome, especialidade, usuario_id) VALUES
('Dr. Alexandre', 'Clínico Geral', 1),
('Dr. Gustavo', 'Cardiologista', 2),
('Dr. Allan', 'Pediatra', 3);

-- Criação de usuários para pacientes
INSERT INTO usuarios (username, password) VALUES
('paciente1', '$2y$10$dMEM0XJ6xijr7r0G7OpYWOkNEjmJ.5Uvh0MJiS2GVmDZGoK8PMYD2'),
('paciente2', '$2y$10$dMEM0XJ6xijr7r0G7OpYWOkNEjmJ.5Uvh0MJiS2GVmDZGoK8PMYD2'),
('paciente3', '$2y$10$dMEM0XJ6xijr7r0G7OpYWOkNEjmJ.5Uvh0MJiS2GVmDZGoK8PMYD2');

-- Criação de pacientes
INSERT INTO pacientes (nome, data_nascimento, tipo_sanguineo, usuario_id) VALUES
('João da Silva', '1990-01-01', 'A+', 4),
('Maria Oliveira', '1985-05-15', 'B-', 5),
('Carlos Pereira', '2000-09-20', 'O+', 6);

-- Criação de consultas (associando médico e paciente)
INSERT INTO consultas (id_medico, id_paciente, data_hora, observacoes) VALUES
(1, 1, '2025-07-10 09:00:00', 'Consulta de rotina.'),
(2, 2, '2025-07-11 14:30:00', 'Paciente com dores no peito.'),
(3, 3, '2025-07-12 08:15:00', 'Exame de rotina para criança.'),
(1, 2, '2025-07-13 10:00:00', 'Retorno para revisão de exames.');
