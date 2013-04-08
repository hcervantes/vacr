SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `hcervant_db` DEFAULT CHARACTER SET big5 ;
USE `hcervant_db` ;

-- -----------------------------------------------------
-- Table `hcervant_db`.`AIRCRAFT`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `hcervant_db`.`AIRCRAFT` (
  `ID` INT(11) NOT NULL AUTO_INCREMENT ,
  `NAME` VARCHAR(45) NULL DEFAULT NULL ,
  `MODELNO` VARCHAR(45) NULL DEFAULT NULL ,
  PRIMARY KEY (`ID`) )
ENGINE = InnoDB
AUTO_INCREMENT = 31
DEFAULT CHARACTER SET = big5
COMMENT = 'LIST OF AIRCRAFT';


-- -----------------------------------------------------
-- Table `hcervant_db`.`CHARACTERISTICS`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `hcervant_db`.`CHARACTERISTICS` (
  `ID` INT(11) NOT NULL AUTO_INCREMENT ,
  `DESCRIPTION` VARCHAR(45) NULL DEFAULT NULL ,
  `AIRCRAFT_ID` INT(11) NOT NULL ,
  PRIMARY KEY (`ID`, `AIRCRAFT_ID`) ,
  INDEX `fk_CHARACTERISTICS_AIRCRAFT1_idx` (`AIRCRAFT_ID` ASC) ,
  CONSTRAINT `fk_CHARACTERISTICS_AIRCRAFT1`
    FOREIGN KEY (`AIRCRAFT_ID` )
    REFERENCES `hcervant_db`.`AIRCRAFT` (`ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 18
DEFAULT CHARACTER SET = big5;


-- -----------------------------------------------------
-- Table `hcervant_db`.`PICTURES`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `hcervant_db`.`PICTURES` (
  `ID` INT(11) NOT NULL AUTO_INCREMENT ,
  `IMAGEPATH` VARCHAR(25) NULL DEFAULT NULL ,
  `AIRCRAFT_ID` INT(11) NOT NULL ,
  PRIMARY KEY (`ID`, `AIRCRAFT_ID`) ,
  INDEX `fk_PICTURES_AIRCRAFT_idx` (`AIRCRAFT_ID` ASC) ,
  CONSTRAINT `fk_PICTURES_AIRCRAFT`
    FOREIGN KEY (`AIRCRAFT_ID` )
    REFERENCES `hcervant_db`.`AIRCRAFT` (`ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 27
DEFAULT CHARACTER SET = big5;

USE `hcervant_db` ;

-- -----------------------------------------------------
-- procedure move_question
-- -----------------------------------------------------

DELIMITER $$
USE `hcervant_db`$$


CREATE DEFINER=`hcervant_hmc`@`localhost` PROCEDURE `move_question`(
v_direction varchar(4),
v_question_id int
)
BEGIN
declare id_up int;
declare priority_up int;
declare id_down int     ;
declare priority_down int;
declare priority_current int;
declare v_quiz_id int;
select priority,quiz_id into priority_current,v_quiz_id from questions where id=v_question_id and parent_id=0;
select id,priority into id_up,priority_up from questions where quiz_id=v_quiz_id and priority<priority_current and parent_id=0 order by priority desc limit 0,1;
select id,priority into id_down,priority_down from questions where quiz_id=v_quiz_id and priority>priority_current and parent_id=0 order by priority limit 0,1;
if v_direction = 'up' then
    if priority_up is not null then
update questions set priority=priority_up where id=v_question_id and parent_id=0;
update questions set priority=priority_current where id=id_up and parent_id=0;
    end if;
ELSEIF  v_direction = 'down' then
    if priority_down is not null then
update questions set priority=priority_down where id=v_question_id and parent_id=0;
update questions set priority=priority_current where id=id_down and parent_id=0;
    end if;
end if ;
END$$

DELIMITER ;

-- -----------------------------------------------------
-- procedure p_quiz_results
-- -----------------------------------------------------

DELIMITER $$
USE `hcervant_db`$$


CREATE DEFINER=`hcervant_hmc`@`localhost` PROCEDURE `p_quiz_results`(
v_user_quiz_id int
)
begin

select total_point,
	   total_perc,
	   user_quiz_id,
	   results_mode,
	   show_results,
	   pass_score,
	   (case results_mode when 1 then ( case when total_point >= pass_score then 1 else 0 end) 
						 when 2 then ( case when total_perc >= pass_score then 1 else 0 end) end ) as quiz_success
	   from (
select ifnull(round(sum((case when q_total < 0 then 0 else q_total end)),2),0) as total_point ,
	   ifnull(round(sum((case when q_perc < 0 then 0 else q_perc end)),2),0) as total_perc ,
	   uqz.id as user_quiz_id,
	   asg.results_mode,
	   asg.show_results,
	   asg.pass_score
from user_quizzes uqz
left join (
select SUM(correct_answers_count) ca_total, 
	   COUNT(*) a_count,
	   question_id,
	   point ,	     
	   (point / (case when question_type_id in (0,1) then (case ca_count when 0 then 1 else ca_count end) else answer_count end ) ) * SUM(correct_answers_count) as q_total,
	   qst.answer_count,
	   question_type_id,
	   ca_count,
	   user_quiz_id,
	   ((100.00/cnts.q_count)/(case when question_type_id in (0,1) then (case ca_count when 0 then 1 else ca_count end) else answer_count end ) ) * SUM(correct_answers_count) as q_perc
	   from (
select (
			case when q.question_type_id in (0,1) then
				case when a.correct_answer=1 then
					1
				else -1 end
				when q.question_type_id in (3,4) then
				case when uq.user_answer_text = a.correct_answer_text then
					1
				else -1 end
			end
		) correct_answers_count ,
		q.point,
		uq.question_id,	
		q.question_type_id,
		q.quiz_id,
		uq.user_quiz_id 
from user_answers uq
left join answers a on a.id = uq.answer_id
left join questions q on q.id = uq.question_id

) total 
left join (

				select count(*) answer_count, SUM(correct_answer) ca_count , qs.id from answers av
				left join question_groups qg on qg.id = av.group_id
			    left join questions qs on qs.id=qg.question_id
			    where av.control_type=1

			    group by qs.id
	
			) qst
on qst.id = total.question_id
left join (
				select COUNT(*) q_count,quiz_id from questions 				

			    group by quiz_id 
			)	cnts on cnts.quiz_id = total.quiz_id
group by question_id ,
		 qst.answer_count,
		 cnts.q_count,
		 point ,question_type_id ,qst.ca_count,
		 user_quiz_id
) results 
on uqz.id=results.user_quiz_id
left join assignments asg on asg.id = uqz.assignment_id
where user_quiz_id=v_user_quiz_id
group by user_quiz_id,
		 asg.results_mode,
		  uqz.id,
	   asg.results_mode,
	   asg.show_results,
	   asg.pass_score
	   ) res ;
	   
end$$

DELIMITER ;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
