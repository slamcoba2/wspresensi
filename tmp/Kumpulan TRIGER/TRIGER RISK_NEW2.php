CREATE TRIGGER `risk_new2`.`InsertToAktifitasPeriode` AFTER INSERT ON `risk_new2`.`tblaktifitasdetil`
  FOR EACH ROW INSERT INTO tblaktifitasdetil_periode SET idResiko=NEW.idResiko,idAktifitas=NEW.idAktifitas,idPeluang=NEW.idPeluang;

CREATE `risk_new2`.`UPDATEtblsumberresiko` AFTER INSERT ON `risk_new2`.`tblaktifitasdetil_periode`
  FOR EACH ROW UPDATE tblsumberresiko SET idResiko=NEW.idResiko
WHERE idAktifitas=NEW.idAktifitas AND idResiko IS NULL;


CREATE DEFINER=`root`@`localhost` TRIGGER `risk_new2`.`INSERTTblsumberresiko_periode` AFTER INSERT ON `risk_new2`.`tblsumberresiko`
  FOR EACH ROW INSERT INTO tblsumberresiko_periode SET idSumberResiko=NEW.idSumberResiko,
idPeriode=NEW.idPeriode;

CREATE DEFINER=`root`@`localhost` TRIGGER `risk_new2`.`UPDATEtblsumberresiko_periode` AFTER UPDATE ON `risk_new2`.`tblsumberresiko`
  FOR EACH ROW UPDATE tblsumberresiko_periode SET idResiko=NEW.idResiko
WHERE idResiko IS NULL AND idSumberResiko=OLD.idSumberResiko;