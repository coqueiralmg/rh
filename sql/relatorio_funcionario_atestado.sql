DELIMITER $$

CREATE PROCEDURE RelatorioFuncionarioAtestado 
(IN periodo_meses INT, 
 IN nome_funcionario VARCHAR(80),
 IN empresa INT,
 IN tipo_funcionario INT)
BEGIN
	DECLARE data_inicial DATE;
    DECLARE data_final DATE;
    
	IF (periodo_meses > 0) THEN
		SET data_final = NOW();
        SET data_inicial = DATE_SUB(@data_final, INTERVAL periodo_meses MONTH);
        
        select f.id,
			   f.matricula Matricula,
			   f.nome Nome,
			   f.cargo Cargo,
			   tf.descricao Tipo,
			   e.nome Empresa,
			   f.probatorio Probatorio,
			   (select count(*)
				  from atestado a
				  where a.funcionario = f.id
					 and a.emissao between data_inicial and data_final) Atestados
		 from funcionario f
		  inner join empresa e
			on f.empresa = e.id
		  inner join tipo_funcionario tf
			on f.tipo = tf.id
		 where f.ativo = 1
         order by Atestados desc;		
    ELSE
		
    END IF;
END $$

DELIMITER ;
											