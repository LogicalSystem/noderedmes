<?php

namespace LogicalSystem\NodeRed;

use app\lib\Utility;
use LogicalSystem\HttpCalls\HttpCalls;

class NodeRed {

    public $baseUrl;
    public $authToken;

    public function __construct($baseUrl, $authToken)
    {
        $this->baseUrl = $baseUrl;
        $this->authToken = $authToken;
    }

    public function getUrloperatori($cod = 0) {
        if($cod == 0) return $this->baseUrl."/operatori";
        else return $this->baseUrl."/operatori/cod/"; 
    }

    public function getUrlFasiTask() {
        return $this->baseUrl."/fasi-task/odl/";
    }

    public function getUrlPutEvento() {
        return $this->baseUrl."/eventi";
    }
    

    public function getCentriDiLavoro($cdl = NULL, $ip = NULL, $id = NULL, $codiceGruppo = NULL, $codiceSquadra = NULL) {
        if(!is_null($cdl)) $url = $this->baseUrl."/centri-di-lavoro/cdl/".$cdl;
        elseif(!is_null($ip)) $url = $this->baseUrl."/centri-di-lavoro/ip/".$ip;
        elseif(!is_null($id)) $url = $this->baseUrl."/centri-di-lavoro/id/".$id;
        elseif(!is_null($codiceGruppo)) $url = $this->baseUrl."/centri-di-lavoro/gruppo/".$codiceGruppo;
        elseif(!is_null($codiceSquadra)) $url = $this->baseUrl."/centri-di-lavoro/squadra/".$codiceSquadra;
        else $url = $this->baseUrl."/centri-di-lavoro";
        return HttpCalls::get($url,["Authorization: ".$this->authToken]);
    }
    

    public function getCentriDiLavoroRaw($id = NULL, $codiceCdl = NULL) {
        if(!is_null($codiceCdl)) $url = $this->baseUrl."/centri-di-lavoro-raw/cdl/".$codiceCdl;
        elseif(!is_null($id)) $url = $this->baseUrl."/centri-di-lavoro-raw/id/".$id;
        else $url = $this->baseUrl."/centri-di-lavoro-raw";
        return HttpCalls::get($url,["Authorization: ".$this->authToken]);
    }



    public function getOrdiniDiLavoro($odl = NULL, $task = NULL) {
        if(!is_null($task)) $url = $this->baseUrl."/ordini-di-lavoro/task/".$task;
        elseif(!is_null($odl)) $url = $this->baseUrl."/ordini-di-lavoro/odl/".$odl;
        else $url = $this->baseUrl."/ordini-di-lavoro";
        return HttpCalls::get($url,["Authorization: ".$this->authToken]);
    }



    public function getOperatori($cod = NULL,$pin = NULL,$id = NULL) {
        if(!is_null($cod)) $url = $this->baseUrl."/operatori/cod/".$cod;
        elseif(!is_null($pin)) $url = $this->baseUrl."/operatori/pin/".$pin;
        elseif(!is_null($id)) $url = $this->baseUrl."/operatori/id/".$id;
        else $url = $this->baseUrl."/operatori";
        return HttpCalls::get($url,["Authorization: ".$this->authToken]);
    }


    public function getOrdiniDiLavoroPossibili($cdl, $odl = NULL) {
        if(is_null($odl)) $url = $this->baseUrl."/ordini-di-lavoroPossibili/cdl/".$cdl;
        else $url = $this->baseUrl."/ordini-di-lavoroPossibili/cdl/".$cdl."/odl/".$odl;
        return HttpCalls::get($url,["Authorization: ".$this->authToken]);
    }


    public function getFasi($task = NULL, $cod = NULL, $codiceOdl = NULL) {
        if(!is_null($task)) $url = $this->baseUrl."/fasi/task/".$task;
        elseif(!is_null($cod)) $url = $this->baseUrl."/fasi/cod/".$cod;
        elseif(!is_null($codiceOdl)) $url = $this->baseUrl."/fasi/odl/".$codiceOdl;
        else $url = $this->baseUrl."/fasi";
        return HttpCalls::get($url,["Authorization: ".$this->authToken]);
    }


    // fasi dell'ordine del lavoro, sulla macchina, che siano tra i task
    public function getFasiTask($odl, $cdl) {
        $url = $this->getUrlFasiTask().$odl."/cdl/".$cdl;
        return HttpCalls::get($url,["Authorization: ".$this->authToken]);
    }


    public function getArticoli($articolo = NULL) {
        if(is_null($articolo)) $url = $this->baseUrl."/articoli";
        else $url = $this->baseUrl."/articoli/cod/".urlencode($articolo);
        return HttpCalls::get($url,["Authorization: ".$this->authToken]);
    }


    public function getTask($id = NULL, $odl = NULL, $cdl = NULL, $parentTask = NULL, $fase = NULL, $codiceOperatore = NULL) {
        if(!is_null($id)) $url = $this->baseUrl."/task/id/".$id;
        elseif(!is_null($odl) && !is_null($fase)) $url = $this->baseUrl."/task/odl/".$odl."/fase/".$fase;
        elseif(!is_null($odl) && !is_null($cdl)) $url = $this->baseUrl."/task/odl/".$odl."/cdl/".$cdl;
        elseif(!is_null($cdl)) $url = $this->baseUrl."/task/cdl/".$cdl;
        elseif(!is_null($odl)) $url = $this->baseUrl."/task/odl/".$odl;
        elseif(!is_null($parentTask)) $url = $this->baseUrl."/task/parent/".$parentTask;
        elseif(!is_null($codiceOperatore)) $url = $this->baseUrl."/task/op/".$codiceOperatore;
        else $url = $this->baseUrl."/task";
        return HttpCalls::get($url,["Authorization: ".$this->authToken]);
    }

    public function getRunningTask($task = NULL, $cdl = NULL, $id = NULL, $codiceOdl = NULL) {
        if(!is_null($task) && !is_null($cdl)) $url = $this->baseUrl."/running-task/task/".$task."/cdl/".$cdl;
        elseif(!is_null($cdl)) $url = $this->baseUrl."/running-task/cdl/".$cdl;
        elseif(!is_null($task)) $url = $this->baseUrl."/running-task/task/".$task;
        elseif(!is_null($id)) $url = $this->baseUrl."/running-task/id/".$id;
        elseif(!is_null($codiceOdl)) $url = $this->baseUrl."/running-task/odl/".$codiceOdl;
        else $url = $this->baseUrl."/running-task";
        return HttpCalls::get($url,["Authorization: ".$this->authToken]);
    }

    public function getUltimoEvento($task = NULL, $cdl = NULL) {
        if(!is_null($task)) $url = $this->baseUrl."/ultimo-evento/task/".$task;
        elseif(!is_null($cdl)) $url = $this->baseUrl."/ultimo-evento/cdl/".$cdl;
        return HttpCalls::get($url,["Authorization: ".$this->authToken]);
    }

    public function getCausaliSospensione($cod = NULL, $gruppo = NULL) {
        if(!is_null($cod)) $url = $this->baseUrl."/causali-sospensione/cod/".$cod;
        elseif(!is_null($gruppo)) $url = $this->baseUrl."/causali-sospensione/gruppo/".$gruppo;
        else $url = $this->baseUrl."/causali-sospensione";
        return HttpCalls::get($url,["Authorization: ".$this->authToken]);
    }

    public function getCausaliScarto($cod = NULL, $gruppo = NULL) {
        if(!is_null($cod)) $url = $this->baseUrl."/causali-scarto/cod/".$cod;
        elseif(!is_null($gruppo)) $url = $this->baseUrl."/causali-scarto/gruppo/".$gruppo;
        else $url = $this->baseUrl."/causali-scarto";
        return HttpCalls::get($url,["Authorization: ".$this->authToken]);
    }

    public function getEventi($id = NULL,$task = NULL, $evento = NULL, $cdl = NULL, $startDate = NULL, $runningTaskId = NULL, $codiceOperatore = NULL) {
        if(!is_null($task) && !is_null($evento)) $url = $this->baseUrl."/eventi/task/".$task."/evento/".$evento;
        elseif(!is_null($task) && !is_null($startDate)) $url = $this->baseUrl."/eventi/task/".$task."/startdate/".$startDate;
        elseif(!is_null($cdl) && !is_null($startDate)) $url = $this->baseUrl."/eventi/cdl/".$cdl."/startdate/".$startDate;
        elseif(!is_null($task)) $url = $this->baseUrl."/eventi/task/".$task;
        elseif(!is_null($runningTaskId) && !is_null($evento)) $url = $this->baseUrl."/eventi/running-task/".$runningTaskId."/evento/".$evento;
        elseif(!is_null($runningTaskId)) $url = $this->baseUrl."/eventi/running-task/".$runningTaskId;
        elseif(!is_null($evento)) $url = $this->baseUrl."/eventi/evento/".$evento;
        elseif(!is_null($cdl)) $url = $this->baseUrl."/eventi/cdl/".$cdl;
        elseif(!is_null($codiceOperatore)) $url = $this->baseUrl."/eventi/operatore/".$codiceOperatore;
        elseif(!is_null($id)) $url = $this->baseUrl."/eventi/id/".$id;
        else $url = $this->baseUrl."/eventi";
        return HttpCalls::get($url,["Authorization: ".$this->authToken]);
    }

    public function getTipiEventi($cod = NULL) {
        if(!is_null($cod)) $url = $this->baseUrl."/tipi-eventi/cod/".$cod;
        else $url = $this->baseUrl."/tipi-eventi";
        return HttpCalls::get($url,["Authorization: ".$this->authToken]);
    }

    public function getStoricoEventi($cdl = NULL, $taskId = NULL) {
        if(!is_null($cdl)) $url = $this->baseUrl."/storico-eventi/cdl/".$cdl;
        elseif(!is_null($taskId)) $url = $this->baseUrl."/storico-eventi/task/".$taskId;
        else $url = $this->baseUrl."/storico-eventi";
        return HttpCalls::get($url,["Authorization: ".$this->authToken]);
    }

    public function getTaskScarti($task = NULL, $cod = NULL, $runningTaskId = NULL) {
        if(!is_null($task) && !is_null($cod)) $url = $this->baseUrl."/task-scarti/task/".$task."/cod/".$cod;
        elseif(!is_null($runningTaskId) && !is_null($cod)) $url = $this->baseUrl."/task-scarti/running-task/".$runningTaskId."/cod/".$cod;
        elseif(!is_null($task)) $url = $this->baseUrl."/task-scarti/task/".$task;
        elseif(!is_null($cod)) $url = $this->baseUrl."/task-scarti/cod/".$cod;
        elseif(!is_null($runningTaskId)) $url = $this->baseUrl."/task-scarti/running-task/".$runningTaskId;
        else $url = $this->baseUrl."/task-scarti";
        return HttpCalls::get($url,["Authorization: ".$this->authToken]);
    }

    public function getCentriDiLavoroIp($codiceCdl = NULL, $ip = NULL) {
        if(!is_null($codiceCdl)) $url = $this->baseUrl."/centri-di-lavoro-ip/cdl/".$codiceCdl;
        if(!is_null($ip)) $url = $this->baseUrl."/centri-di-lavoro-ip/ip/".$ip;
        else $url = $this->baseUrl."/centri-di-lavoro-ip";
        return HttpCalls::get($url,["Authorization: ".$this->authToken]);
    }

    public function getDistintaBase($codart = NULL, $odl = NULL, $id = NULL, $mat = NULL, $alt = "false", $codiceFase = NULL) {
        if(!is_null($mat) && !is_null($odl)) $url = $this->baseUrl."/distinta-base/mat/".$mat."/odl/".$odl;
        elseif(!is_null($codiceFase) && !is_null($odl)) $url = $this->baseUrl."/distinta-base/odl/".$odl."/fase/".$codiceFase;
        elseif(!is_null($codart)) $url = $this->baseUrl."/distinta-base/cod/".$codart."/alt/".$alt;
        elseif(!is_null($odl)) $url = $this->baseUrl."/distinta-base/odl/".$odl."/alt/".$alt;
        elseif(!is_null($id)) $url = $this->baseUrl."/distinta-base/id/".$id;
        else $url = $this->baseUrl."/distinta-base";
        return HttpCalls::get($url,["Authorization: ".$this->authToken]);
    }

    public function getLotti($codl = NULL, $codm = NULL) {
        if(!is_null($codl)) $url = $this->baseUrl."/lotti/codice-lotto/".$codl;
        elseif(!is_null($codm)) $url = $this->baseUrl."/lotti/codice-materiale/".$codm;
        else $url = $this->baseUrl."/lotti";
        return HttpCalls::get($url,["Authorization: ".$this->authToken]);
    }

    public function getDistintaBaseUsata($runningTask = NULL, $task = NULL, $distintaId = NULL, $codiceOdl = NULL) {
        if(!is_null($task)) $url = $this->baseUrl."/distinta-base-usata/task/".$task;
        elseif(!is_null($distintaId)) $url = $this->baseUrl."/distinta-base-usata/distinta/".$distintaId;
        elseif(!is_null($codiceOdl)) $url = $this->baseUrl."/distinta-base-usata/odl/".$codiceOdl;
        elseif(!is_null($runningTask)) $url = $this->baseUrl."/distinta-base-usata/rtask/".$runningTask;
        else $url = $this->baseUrl."/distinta-base-usata";
        return HttpCalls::get($url,["Authorization: ".$this->authToken]);
    }

    public function getOperatoriEventi($cdl = NULL, $op = NULL) {
        if(!is_null($cdl) && !is_null($op)) $url = $this->baseUrl."/operatori-eventi/cdl/".$cdl."/op/".$op;
        elseif(!is_null($cdl)) $url = $this->baseUrl."/operatori-eventi/cdl/".$cdl;
        elseif(!is_null($op)) $url = $this->baseUrl."/operatori-eventi/op/".$op;
        else $url = $this->baseUrl."/operatori-eventi";
        return HttpCalls::get($url,["Authorization: ".$this->authToken]);
    }

    public function getDistintaBaseAlternativi($odl, $mat) {
        if(!is_null($mat) && !is_null($odl)) $url = $this->baseUrl."/distinta-base-alternativi/mat/".$mat."/odl/".$odl;
        else $url = $this->baseUrl."/distinta-base-alternativi";
        return HttpCalls::get($url,["Authorization: ".$this->authToken]);
    }

    public function getDistintaBasePadre($odl, $mat) {
        if(!is_null($mat) && !is_null($odl)) $url = $this->baseUrl."/distinta-base-padre/mat/".$mat."/odl/".$odl;
        else $url = $this->baseUrl."/distinta-base-padre";
        return HttpCalls::get($url,["Authorization: ".$this->authToken]);
    }

    public function getGruppiCausaliSospensione($cod = NULL) {
        if(!is_null($cod)) $url = $this->baseUrl."/causali-sospensione-gruppi/cod/".$cod;
        else $url = $this->baseUrl."/causali-sospensione-gruppi";
        return HttpCalls::get($url,["Authorization: ".$this->authToken]);
    }

    public function getGruppiCausaliScarto($cod = NULL) {
        if(!is_null($cod)) $url = $this->baseUrl."/causali-scarto-gruppi/cod/".$cod;
        else $url = $this->baseUrl."/causali-scarto-gruppi";
        return HttpCalls::get($url,["Authorization: ".$this->authToken]);
    }

    public function getReparti($cod = NULL) {
        if(!is_null($cod)) $url = $this->baseUrl."/reparti/cod/".$cod;
        else $url = $this->baseUrl."/reparti";
        return HttpCalls::get($url,["Authorization: ".$this->authToken]);
    }

    public function getRepartoOperatori($codReparto = NULL) {
        if(!is_null($codReparto)) $url = $this->baseUrl."/reparti-operatori/cod/".$codReparto;
        else $url = $this->baseUrl."/reparti-operatori";
        return HttpCalls::get($url,["Authorization: ".$this->authToken]);
    }

    public function getRepartoCentriDiLavoro($codReparto = NULL, $codCdl = NULL) {
        if(!is_null($codReparto)) $url = $this->baseUrl."/reparti-centri-di-lavoro/cod/".$codReparto;
        elseif(!is_null($codCdl)) $url = $this->baseUrl."/reparti-centri-di-lavoro/codcdl/".$codCdl;
        else $url = $this->baseUrl."/reparti-centri-di-lavoro";
        return HttpCalls::get($url,["Authorization: ".$this->authToken]);
    }

    public function getTaskToDo($cdl, $ntask = 5) {
        $url = $this->baseUrl."/task-to-do/cdl/".$cdl."/ntask/".$ntask;
        return HttpCalls::get($url,["Authorization: ".$this->authToken]);
    }

    public function getCentroDiLavoroStato($cdl = NULL) {
        if(!is_null($cdl)) $url = $this->baseUrl."/centri-di-lavoro-stato/cdl/".$cdl;
        else $url = $this->baseUrl."/centri-di-lavoro-stato";
        return HttpCalls::get($url,["Authorization: ".$this->authToken]);
    }

    public function getEtichette($codiceEtichetta = NULL, $taskid = NULL, $tipo = NULL) {
        if(!is_null($codiceEtichetta)) $url = $this->baseUrl."/etichette/codice/".$codiceEtichetta;
        elseif(!is_null($taskid) && !is_null($tipo)) $url = $this->baseUrl."/etichette/task/".$taskid."/tipo/".$tipo;
        elseif(!is_null($taskid)) $url = $this->baseUrl."/etichette/task/".$taskid;
        elseif(!is_null($tipo)) $url = $this->baseUrl."/etichette/tipo/".$tipo;
        else $url = $this->baseUrl."/etichette";
        return HttpCalls::get($url,["Authorization: ".$this->authToken]);
    }

    public function getImballi($codiceImballo = NULL, $tipo = NULL) {
        if(!is_null($codiceImballo)) $url = $this->baseUrl."/imballi/codice/".$codiceImballo;
        elseif(!is_null($tipo)) $url = $this->baseUrl."/imballi/tipo/".$tipo;
        else $url = $this->baseUrl."/imballi";
        return HttpCalls::get($url,["Authorization: ".$this->authToken]);
    }

    public function getAttrezzature($codiceAttrezzatura = NULL, $codiceOdl = NULL, $codiceFase = NULL) {
        if(!is_null($codiceAttrezzatura) && !is_null($codiceOdl) && !is_null($codiceFase)) $url = $this->baseUrl."/attrezzature/codice/".$codiceAttrezzatura."/odl/".$codiceOdl."/fase/".$codiceFase;
        elseif(!is_null($codiceOdl) && !is_null($codiceFase)) $url = $this->baseUrl."/attrezzature/odl/".$codiceOdl."/fase/".$codiceFase;
        elseif(!is_null($codiceAttrezzatura)) $url = $this->baseUrl."/attrezzature/codice/".$codiceAttrezzatura;
        elseif(!is_null($codiceOdl)) $url = $this->baseUrl."/attrezzature/odl/".$codiceOdl;
        elseif(!is_null($codiceFase)) $url = $this->baseUrl."/attrezzature/fase/".$codiceFase;
        else $url = $this->baseUrl."/attrezzature";
        return HttpCalls::get($url,["Authorization: ".$this->authToken]);
    }

    public function getWebhook($id = NULL,$codiceEvento = NULL) {
        if(!is_null($id)) $url = $this->baseUrl."/webhook/id/".$id;
        elseif(!is_null($codiceEvento)) $url = $this->baseUrl."/webhook/codice/".$codiceEvento;
        else $url = $this->baseUrl."/webhook";
        return HttpCalls::get($url,["Authorization: ".$this->authToken]);
    }

    public function getLottiProduzione($id = NULL,$taskId = NULL,$stepTask = NULL,$codiceOdl = NULL,$codiceFase = NULL) {
        if(!is_null($id)) $url = $this->baseUrl."/lotti-produzione/id/".$id;
        elseif(!is_null($codiceOdl) && !is_null($stepTask) && !is_null($codiceFase)) $url = $this->baseUrl."/lotti-produzione/odl/".$codiceOdl."/fase/".$codiceFase."/step/".$stepTask;
        elseif(!is_null($codiceOdl) && !is_null($stepTask)) $url = $this->baseUrl."/lotti-produzione/odl/".$codiceOdl."/step/".$stepTask;
        elseif(!is_null($codiceOdl)) $url = $this->baseUrl."/lotti-produzione/odl/".$codiceOdl;
        elseif(!is_null($taskId)) $url = $this->baseUrl."/lotti-produzione/task/".$taskId;
        else $url = $this->baseUrl."/lotti-produzione";
        return HttpCalls::get($url,["Authorization: ".$this->authToken]);
    }


    public function getLottiAttrezzature($coda = NULL, $identificativo = NULL) {
        if(!is_null($coda)) $url = $this->baseUrl."/attrezzature-lotti/codice-attrezzatura/".$coda;
        elseif(!is_null($identificativo)) $url = $this->baseUrl."/attrezzature-lotti/identificativo/".$identificativo;
        else $url = $this->baseUrl."/attrezzature-lotti";
        return HttpCalls::get($url,["Authorization: ".$this->authToken]);
    }

    public function getAttrezzaturaUsata($runningTask = NULL, $task = NULL, $codiceAttrezzatura = NULL) {
        if(!is_null($task)) $url = $this->baseUrl."/attrezzature-usate/task/".$task;
        elseif(!is_null($runningTask) && !is_null($codiceAttrezzatura)) $url = $this->baseUrl."/attrezzature-usate/rtask/".$runningTask."/coda/".$codiceAttrezzatura;
        elseif(!is_null($runningTask)) $url = $this->baseUrl."/attrezzature-usate/rtask/".$runningTask;
        elseif(!is_null($codiceAttrezzatura)) $url = $this->baseUrl."/attrezzature-usate/coda/".$codiceAttrezzatura;
        else $url = $this->baseUrl."/attrezzature-usate";
        return HttpCalls::get($url,["Authorization: ".$this->authToken]);
    }

    public function getAttrezzaturaUsataValutazione($id = NULL, $attrezzaturaUsataId = NULL) {
        if(!is_null($id)) $url = $this->baseUrl."/attrezzature-usate-valutazione/id/".$id;
        elseif(!is_null($attrezzaturaUsataId)) $url = $this->baseUrl."/attrezzature-usate-valutazione/attrusid/".$attrezzaturaUsataId;
        else $url = $this->baseUrl."/attrezzature-usate-valutazione";
        return HttpCalls::get($url,["Authorization: ".$this->authToken]);
    }

    public function getCentroDiLavoroManutenzione($cdl = NULL) {
        if(!is_null($cdl)) $url = $this->baseUrl."/centri-di-lavoro-manutenzione/cdl/".$cdl;
        else $url = $this->baseUrl."/centri-di-lavoro-manutenzione";
        return HttpCalls::get($url,["Authorization: ".$this->authToken]);
    }

    public function getCentroDiLavoroManutenzioneStorico($cdl = NULL,$tipo = NULL) {
        if(!is_null($cdl) && !is_null($tipo)) $url = $this->baseUrl."/centri-di-lavoro-manutenzione-storico/cdl/".$cdl."/tipo/".$tipo;
        elseif(!is_null($cdl)) $url = $this->baseUrl."/centri-di-lavoro-manutenzione-storico/cdl/".$cdl;
        elseif(!is_null($tipo)) $url = $this->baseUrl."/centri-di-lavoro-manutenzione-storico/tipo/".$tipo;
        else $url = $this->baseUrl."/centri-di-lavoro-manutenzione-storico";
        return HttpCalls::get($url,["Authorization: ".$this->authToken]);
    }

    public function getAttivitaExtra($codice = NULL) {
        if(!is_null($codice)) $url = $this->baseUrl."/attivita-extra/cod/".$codice;
        else $url = $this->baseUrl."/attivita-extra";
        return HttpCalls::get($url,["Authorization: ".$this->authToken]);
    }

    public function getAttivitaTask($codice = NULL, $taskId = NULL) {
        if(!is_null($codice)) $url = $this->baseUrl."/attivita-task/cod/".$codice;
        elseif(!is_null($taskId)) $url = $this->baseUrl."/attivita-task/task/".$taskId;
        else $url = $this->baseUrl."/attivita-task";
        return HttpCalls::get($url,["Authorization: ".$this->authToken]);
    }

    public function getIfttt($id = NULL,$codiceCdl = NULL) {
        if(!is_null($id)) $url = $this->baseUrl."/ifttt/id/".$id;
        elseif(!is_null($codiceCdl)) $url = $this->baseUrl."/ifttt/cod/".$codiceCdl;
        else $url = $this->baseUrl."/ifttt";
        return HttpCalls::get($url,["Authorization: ".$this->authToken]);
    }

    public function getIftttEventi($id = NULL,$codiceCdl = NULL) {
        if(!is_null($id)) $url = $this->baseUrl."/ifttt-eventi/id/".$id;
        elseif(!is_null($codiceCdl)) $url = $this->baseUrl."/ifttt-eventi/cod/".$codiceCdl;
        else $url = $this->baseUrl."/ifttt-eventi";
        return HttpCalls::get($url,["Authorization: ".$this->authToken]);
    }

    public function getSfrido($taskId = NULL, $codiceMateriale = NULL, $codiceCausale = NULL) {
        if(!is_null($taskId) && !is_null($codiceMateriale) && !is_null($codiceCausale)) $url = $this->baseUrl."/sfrido/task/".$taskId."/mat/".$codiceMateriale."/cau/".$codiceCausale;
        elseif(!is_null($taskId) && !is_null($codiceMateriale)) $url = $this->baseUrl."/sfrido/task/".$taskId."/mat/".$codiceMateriale;
        elseif(!is_null($taskId)) $url = $this->baseUrl."/sfrido/task/".$taskId;
        elseif(!is_null($codiceMateriale)) $url = $this->baseUrl."/sfrido/mat/".$codiceMateriale;
        elseif(!is_null($codiceCausale)) $url = $this->baseUrl."/sfrido/cau/".$codiceCausale;
        else $url = $this->baseUrl."/sfrido";
        return HttpCalls::get($url,["Authorization: ".$this->authToken]);
    }

    public function getCentriDiLavoroProcessi($codiceCdl = NULL, $processName = NULL) {
        if(!is_null($codiceCdl)) $url = $this->baseUrl."/centri-di-lavoro-processi/cdl/".$codiceCdl;
        elseif(!is_null($processName)) $url = $this->baseUrl."/centri-di-lavoro-processi/process/".$processName;
        else $url = $this->baseUrl."/centri-di-lavoro-processi";
        return HttpCalls::get($url,["Authorization: ".$this->authToken]);
    }

    public function getTaskNote($taskId = NULL, $runningTaskId = NULL) {
        if(!is_null($taskId)) $url = $this->baseUrl."/task-note/task/".$taskId;
        elseif(!is_null($runningTaskId)) $url = $this->baseUrl."/task-note/rt/".$runningTaskId;
        else $url = $this->baseUrl."/task-note";
        return HttpCalls::get($url,["Authorization: ".$this->authToken]);
    }

    public function getCentriDiLavoroGruppi($cod = NULL) {
        if(!is_null($cod)) $url = $this->baseUrl."/centri-di-lavoro-gruppi/cod/".$cod;
        else $url = $this->baseUrl."/centri-di-lavoro-gruppi";
        return HttpCalls::get($url,["Authorization: ".$this->authToken]);
    }

    public function getCausaliEventi($cdl = NULL, $codiceCausale = NULL) {
        if(!is_null($cdl) && !is_null($codiceCausale)) $url = $this->baseUrl."/causali-eventi/cdl/".$cdl."/cau/".$codiceCausale;
        elseif(!is_null($cdl)) $url = $this->baseUrl."/causali-eventi/cdl/".$cdl;
        elseif(!is_null($codiceCausale)) $url = $this->baseUrl."/causali-eventi/cau/".$codiceCausale;
        else $url = $this->baseUrl."/causali-eventi";
        return HttpCalls::get($url,["Authorization: ".$this->authToken]);
    }

    public function getRuoli($cod = NULL) {
        if(!is_null($cod)) $url = $this->baseUrl."/ruoli/cod/".$cod;
        else $url = $this->baseUrl."/ruoli";
        return HttpCalls::get($url,["Authorization: ".$this->authToken]);
    }

    public function getRuoloOperatori($codRuolo = NULL,$codiceOperatore = NULL) {
        if(!is_null($codRuolo)) $url = $this->baseUrl."/ruoli-operatori/cod/".$codRuolo;
        elseif(!is_null($codiceOperatore)) $url = $this->baseUrl."/ruoli-operatori/op/".$codiceOperatore;
        else $url = $this->baseUrl."/ruoli-operatori";
        return HttpCalls::get($url,["Authorization: ".$this->authToken]);
    }

    public function getCdlOperatori($codiceCdl = NULL, $codiceOperatore = NULL) {
        if(!is_null($codiceCdl)) $url = $this->baseUrl."/centri-di-lavoro-operatori/cod/".$codiceCdl;
        elseif(!is_null($codiceOperatore)) $url = $this->baseUrl."/centri-di-lavoro-operatori/op/".$codiceOperatore;
        else $url = $this->baseUrl."/centri-di-lavoro-operatori";
        return HttpCalls::get($url,["Authorization: ".$this->authToken]);
    }

    public function getNotifiche($id = NULL,$codiceNotifica = NULL,$codiceEvento = NULL) {
        if(!is_null($codiceNotifica)) $url = $this->baseUrl."/notifiche/cod/".$codiceNotifica;
        elseif(!is_null($codiceEvento)) $url = $this->baseUrl."/notifiche/evento/".$codiceEvento;
        else $url = $this->baseUrl."/notifiche";
        return HttpCalls::get($url,["Authorization: ".$this->authToken]);
    }

    public function getNotificheInviate($id = NULL,$codiceNotifica = NULL,$codiceOperatore = NULL) {
        if(!is_null($codiceNotifica)) $url = $this->baseUrl."/notifiche-inviate/cod/".$codiceNotifica;
        elseif(!is_null($id)) $url = $this->baseUrl."/notifiche-inviate/id/".$id;
        elseif(!is_null($codiceOperatore)) $url = $this->baseUrl."/notifiche-inviate/op/".$codiceOperatore;
        else $url = $this->baseUrl."/notifiche-inviate";
        return HttpCalls::get($url,["Authorization: ".$this->authToken]);
    }

    public function getOrari($id = NULL,$tipologia = NULL,$codiceOrario = NULL) {
        if(!is_null($id)) $url = $this->baseUrl."/orari/id/".$id;
        elseif(!is_null($tipologia)) $url = $this->baseUrl."/orari/tipologia/".$tipologia;
        elseif(!is_null($codiceOrario)) $url = $this->baseUrl."/orari/cod/".$codiceOrario;
        else $url = $this->baseUrl."/orari";
        return HttpCalls::get($url,["Authorization: ".$this->authToken]);
    }

    public function getSkill($codice = NULL) {
        if(!is_null($codice)) $url = $this->baseUrl."/skill/cod/".$codice;
        else $url = $this->baseUrl."/skill";
        return HttpCalls::get($url,["Authorization: ".$this->authToken]);
    }

    public function getSkillOperatori($codSkill = NULL,$codiceOperatore = NULL) {
        if(!is_null($codSkill)) $url = $this->baseUrl."/skill-operatori/cod/".$codSkill;
        elseif(!is_null($codiceOperatore)) $url = $this->baseUrl."/skill-operatori/op/".$codiceOperatore;
        else $url = $this->baseUrl."/skill-operatori";
        return HttpCalls::get($url,["Authorization: ".$this->authToken]);
    }

    public function getOrdiniDiLavoroLink($cod1 = NULL, $cod2 = NULL) {
        if(!is_null($cod1) && !is_null($cod2)) $url = $this->baseUrl."/ordini-di-lavoro-link/cod1/".$cod1."/cod2/".$cod2;
        elseif(!is_null($cod1)) $url = $this->baseUrl."/ordini-di-lavoro-link/cod1/".$cod1;
        elseif(!is_null($cod2)) $url = $this->baseUrl."/ordini-di-lavoro-link/cod1/".$cod2;
        else $url = $this->baseUrl."/ordini-di-lavoro-link";
        return HttpCalls::get($url,["Authorization: ".$this->authToken]);
    }

    public function getTurni($id = NULL,$codice = NULL,$codiceOrario = NULL) {
        if(!is_null($codice)) $url = $this->baseUrl."/turni/codice/".$codice;
        elseif(!is_null($id)) $url = $this->baseUrl."/turni/id/".$id;
        elseif(!is_null($id)) $url = $this->baseUrl."/turni/codice-orario/".$codiceOrario;
        else $url = $this->baseUrl."/turni";
        return HttpCalls::get($url,["Authorization: ".$this->authToken]);
    }

    public function getSquadre($id = NULL,$codice = NULL,$codiceOperatore = NULL) {
        if(!is_null($codice)) $url = $this->baseUrl."/squadre/codice/".$codice;
        elseif(!is_null($id)) $url = $this->baseUrl."/squadre/id/".$id;
        elseif(!is_null($id)) $url = $this->baseUrl."/squadre/operatore/".$codiceOperatore;
        else $url = $this->baseUrl."/squadre";
        return HttpCalls::get($url,["Authorization: ".$this->authToken]);
    }

    public function getProtocolliMisurazioni($id = NULL, $protocollo = NULL, $item = NULL, $endPoint = NULL) {
        if(!is_null($id)) $url = $this->baseUrl."/protocolli-misurazioni/id/".$id;
        elseif(!is_null($protocollo) && !is_null($item) && !is_null($endPoint)) $url = $this->baseUrl."/protocolli-misurazioni/endpoint/".$endPoint."/protocollo/".$protocollo."/item/".$item;
        elseif(!is_null($protocollo) && !is_null($item)) $url = $this->baseUrl."/protocolli-misurazioni/protocollo/".$protocollo."/item/".$item;
        elseif(!is_null($protocollo)) $url = $this->baseUrl."/protocolli-misurazioni/protocollo/".$protocollo;
        elseif(!is_null($item)) $url = $this->baseUrl."/protocolli-misurazioni/item/".$item;
        else $url = $this->baseUrl."/protocolli-misurazioni";
        return HttpCalls::get($url,["Authorization: ".$this->authToken]);
    }

    public function getCentriDiLavoroProtocolliMisurazioni($id = NULL, $codiceCdl = NULL, $protocollo = NULL, $item = NULL, $protocolloId = NULL, $endPoint = NULL) {
        if(!is_null($id)) $url = $this->baseUrl."/centri-di-lavoro-protocolli-misurazioni/id/".$id;
        elseif(!is_null($protocollo) && !is_null($item) && !is_null($codiceCdl)) $url = $this->baseUrl."/centri-di-lavoro-protocolli-misurazioni/cdl/".$codiceCdl."/protocollo/".$protocollo."/item/".$item;
        elseif(!is_null($protocollo) && !is_null($item) && !is_null($endPoint)) $url = $this->baseUrl."/centri-di-lavoro-protocolli-misurazioni/endpoint/".$endPoint."/protocollo/".$protocollo."/item/".$item;
        elseif(!is_null($codiceCdl) && !is_null($protocollo)) $url = $this->baseUrl."/centri-di-lavoro-protocolli-misurazioni/cdl/".$codiceCdl."/protocollo/".$protocollo;
        elseif(!is_null($codiceCdl) && !is_null($protocolloId)) $url = $this->baseUrl."/centri-di-lavoro-protocolli-misurazioni/cdl/".$codiceCdl."/protocollo-id/".$protocolloId;
        elseif(!is_null($protocollo)) $url = $this->baseUrl."/centri-di-lavoro-protocolli-misurazioni/protocollo/".$protocollo;
        elseif(!is_null($codiceCdl)) $url = $this->baseUrl."/centri-di-lavoro-protocolli-misurazioni/cdl/".$codiceCdl;
        elseif(!is_null($item)) $url = $this->baseUrl."/centri-di-lavoro-protocolli-misurazioni/item/".$item;
        elseif(!is_null($protocolloId)) $url = $this->baseUrl."/centri-di-lavoro-protocolli-misurazioni/protocollo-id/".$protocolloId;
        else $url = $this->baseUrl."/centri-di-lavoro-protocolli-misurazioni";
        return HttpCalls::get($url,["Authorization: ".$this->authToken]);
    }

    public function getMisurazioniUnita($id = NULL, $type = NULL, $name = NULL) {
        if(!is_null($id)) $url = $this->baseUrl."/misurazioni-unita/id/".$id;
        elseif(!is_null($type) && !is_null($name)) $url = $this->baseUrl."/misurazioni-unita/type/".$type."/name/".$name;
        elseif(!is_null($type)) $url = $this->baseUrl."/misurazioni-unita/type/".$type;
        elseif(!is_null($name)) $url = $this->baseUrl."/misurazioni-unita/name/".$name;
        else $url = $this->baseUrl."/misurazioni-unita";
        return HttpCalls::get($url,["Authorization: ".$this->authToken]);
    }

    public function getStoricoMisurazioni($id = NULL, $startDate = NULL, $protocollo = NULL, $item = NULL, $ultimo = NULL, $endPoint = NULL, $endDate = NULL, $filter = false, $limit = 100) {
        $url = $this->baseUrl."/storico-misurazioni";
        if($filter) {
            $url .= "/filter?";
            $filter = [];
            if(!is_null($id)) $filter[] = "id=".$id;
            if(!is_null($protocollo)) $filter[] = "protocol=".$protocollo;
            if(!is_null($item)) $filter[] = "item=".$item;
            if(!is_null($endPoint)) $filter[] = "endpoint=".$endPoint;
            if(!is_null($startDate)) $filter[] = "startdate=".$startDate;
            if(!is_null($endDate)) $filter[] = "enddate=".$endDate;
            if(!is_null($limit)) $filter[] = "limit=".$limit;
            $url .= implode("&",$filter);
        } else {
            if(!is_null($id)) $url .= "/id/".$id;
            if(!is_null($ultimo)) $url .= "/ultimo";
            if(!is_null($protocollo)) $url .= "/protocollo/".$protocollo;
            if(!is_null($item)) $url .= "/item/".$item;
            if(!is_null($endPoint)) $url .= "/endpoint/".$endPoint;
            if(!is_null($startDate)) $url .= "/startdate/".$startDate;
            if(!is_null($endDate)) $url .= "/enddate/".$endDate;
        }
        return HttpCalls::get($url,["Authorization: ".$this->authToken]);
    }

    public function getLottiSeriali($id = NULL, $codiceOdl = NULL, $codiceFase = NULL) {
        if(!is_null($id)) $url = $this->baseUrl."/lotti-seriali/id/".$id;
        elseif(!is_null($codiceOdl) && !is_null($codiceFase)) $url = $this->baseUrl."/lotti-seriali/odl/".$codiceOdl."/fase/".$codiceFase;
        elseif(!is_null($codiceOdl)) $url = $this->baseUrl."/lotti-seriali/odl/".$codiceOdl;
        elseif(!is_null($codiceFase)) $url = $this->baseUrl."/lotti-seriali/fase/".$codiceFase;
        else $url = $this->baseUrl."/lotti-seriali";
        return HttpCalls::get($url,["Authorization: ".$this->authToken]);
    }

    public function getStoricoMisurazioniBuffer($id = NULL, $startDate = NULL, $protocollo = NULL, $item = NULL, $ultimo = NULL, $endPoint = NULL) {
        if(!is_null($id)) $url = $this->baseUrl."/storico-misurazioni-buffer/id/".$id;
        elseif(!is_null($ultimo) && !is_null($item) && !is_null($protocollo) && !is_null($endPoint)) $url = $this->baseUrl."/storico-misurazioni-buffer/ultimo/protocollo/".$protocollo."/item/".$item."/endpoint/".$endPoint;
        elseif(!is_null($ultimo) && !is_null($item) && !is_null($protocollo)) $url = $this->baseUrl."/storico-misurazioni-buffer/ultimo/protocollo/".$protocollo."/item/".$item;
        elseif(!is_null($startDate)) $url = $this->baseUrl."/storico-misurazioni-buffer/startdate/".$startDate;
        elseif(!is_null($ultimo)) $url = $this->baseUrl."/storico-misurazioni-buffer/ultimo";
        else $url = $this->baseUrl."/storico-misurazioni-buffer";
        return HttpCalls::get($url,["Authorization: ".$this->authToken]);
    }


    







    public function putRunningTask($data) {
        $url = $this->baseUrl."/running-task";
        return HttpCalls::put($url,$data,"application/json",["Authorization: ".$this->authToken]);
    }

    public function putTaskScarti($data) {
        $url = $this->baseUrl."/task-scarti";
        return HttpCalls::put($url,$data,"application/json",["Authorization: ".$this->authToken]);
    }

    public function putCentriDiLavoroIp($data) {
        $url = $this->baseUrl."/centri-di-lavoro-ip";
        return HttpCalls::put($url,$data,"application/json",["Authorization: ".$this->authToken]);
    }

    public function putDistintaBase($data) {
        $url = $this->baseUrl."/distinta-base";
        return HttpCalls::put($url,$data,"application/json",["Authorization: ".$this->authToken]);
    }

    public function putLotti($data) {
        $url = $this->baseUrl."/lotti";
        return HttpCalls::put($url,$data,"application/json",["Authorization: ".$this->authToken]);
    }
    
    public function putDistintaBaseUsata($data) {
        $url = $this->baseUrl."/distinta-base-usata";
        return HttpCalls::put($url,$data,"application/json",["Authorization: ".$this->authToken]);
    }

    public function putReparto($data) {
        $url = $this->baseUrl."/reparti";
        return HttpCalls::put($url,$data,"application/json",["Authorization: ".$this->authToken]);
    }

    public function putCentroDiLavoroStato($data) {
        $url = $this->baseUrl."/centri-di-lavoro-stato";
        return HttpCalls::put($url,$data,"application/json",["Authorization: ".$this->authToken]);
    }

    public function putLottiAttrezzature($data) {
        $url = $this->baseUrl."/attrezzature-lotti";
        return HttpCalls::put($url,$data,"application/json",["Authorization: ".$this->authToken]);
    }

    public function putAttrezzaturaUsata($data) {
        $url = $this->baseUrl."/attrezzature-usate";
        return HttpCalls::put($url,$data,"application/json",["Authorization: ".$this->authToken]);
    }

    public function putAttrezzaturaUsataValutazione($data) {
        $url = $this->baseUrl."/attrezzature-usate-valutazione";
        return HttpCalls::put($url,$data,"application/json",["Authorization: ".$this->authToken]);
    }

    public function putCentroDiLavoroManutenzione($data) {
        $url = $this->baseUrl."/centri-di-lavoro-manutenzione";
        return HttpCalls::put($url,$data,"application/json",["Authorization: ".$this->authToken]);
    }

    public function putAttivitaExtra($data) {
        $url = $this->baseUrl."/attivita-extra";
        return HttpCalls::put($url,$data,"application/json",["Authorization: ".$this->authToken]);
    }

    public function putAttivitaTask($data) {
        $url = $this->baseUrl."/attivita-task";
        return HttpCalls::put($url,$data,"application/json",["Authorization: ".$this->authToken]);
    }

    public function putIfttt($data) {
        $url = $this->baseUrl."/ifttt";
        return HttpCalls::put($url,$data,"application/json",["Authorization: ".$this->authToken]);
    }

    public function putSfrido($data) {
        $url = $this->baseUrl."/sfrido";
        return HttpCalls::put($url,$data,"application/json",["Authorization: ".$this->authToken]);
    }

    public function putCentriDiLavoroProcessi($data) {
        $url = $this->baseUrl."/centri-di-lavoro-processi";
        return HttpCalls::put($url,$data,"application/json",["Authorization: ".$this->authToken]);
    }

    public function putCentriDiLavoroGruppi($data) {
        $url = $this->baseUrl."/centri-di-lavoro-gruppi";
        return HttpCalls::put($url,$data,"application/json",["Authorization: ".$this->authToken]);
    }

    public function putRuolo($data) {
        $url = $this->baseUrl."/ruoli";
        return HttpCalls::put($url,$data,"application/json",["Authorization: ".$this->authToken]);
    }

    public function putNotifica($data) {
        $url = $this->baseUrl."/notifiche";
        return HttpCalls::put($url,$data,"application/json",["Authorization: ".$this->authToken]);
    }

    public function putOperatore($data) {
        $url = $this->baseUrl."/operatori";
        return HttpCalls::put($url,$data,"application/json",["Authorization: ".$this->authToken]);
    }

    public function putSkill($data) {
        $url = $this->baseUrl."/skill";
        return HttpCalls::put($url,$data,"application/json",["Authorization: ".$this->authToken]);
    }

    public function putRunningTaskStatus($data) {
        $url = $this->baseUrl."/running-task-status";
        return HttpCalls::put($url,$data,"application/json",["Authorization: ".$this->authToken]);
    }

    public function putRunningTaskQnt($data) {
        $url = $this->baseUrl."/running-task-quantity";
        return HttpCalls::put($url,$data,"application/json",["Authorization: ".$this->authToken]);
    }

    public function putTaskQnt($data) {
        $url = $this->baseUrl."/task-quantity";
        return HttpCalls::put($url,$data,"application/json",["Authorization: ".$this->authToken]);
    }

    public function putRunningTaskCausaliSospensione($data) {
        $url = $this->baseUrl."/running-task-causali-sospensione";
        return HttpCalls::put($url,$data,"application/json",["Authorization: ".$this->authToken]);
    }

    public function putUpdateCausaliSospensione($data) {
        $url = $this->baseUrl."/causali-sospensione-update-gruppo";
        return HttpCalls::put($url,$data,"application/json",["Authorization: ".$this->authToken]);
    }

    public function putUpdateCausaliScarto($data) {
        $url = $this->baseUrl."/causali-scarto-update-gruppo";
        return HttpCalls::put($url,$data,"application/json",["Authorization: ".$this->authToken]);
    }

    public function putGruppoSospensione($data) {
        $url = $this->baseUrl."/causali-sospensione-gruppi";
        return HttpCalls::put($url,$data,"application/json",["Authorization: ".$this->authToken]);
    }

    public function putGruppoScarto($data) {
        $url = $this->baseUrl."/causali-scarto-gruppi";
        return HttpCalls::put($url,$data,"application/json",["Authorization: ".$this->authToken]);
    }

    public function putTaskEliminato($data) {
        $url = $this->baseUrl."/task-eliminati";
        return HttpCalls::put($url,$data,"application/json",["Authorization: ".$this->authToken]);
    }

    public function putRunningTaskImpronte($data) {
        $url = $this->baseUrl."/running-task-impronte";
        return HttpCalls::put($url,$data,"application/json",["Authorization: ".$this->authToken]);
    }

    public function putWebhook($data) {
        $url = $this->baseUrl."/webhook";
        return HttpCalls::put($url,$data,"application/json",["Authorization: ".$this->authToken]);
    }

    public function putCentroDiLavoroStatoProd($data) {
        $url = $this->baseUrl."/centri-di-lavoro-stato-produzione";
        return HttpCalls::put($url,$data,"application/json",["Authorization: ".$this->authToken]);
    }

    public function putCentroDiLavoroAbilitato($data) {
        $url = $this->baseUrl."/centri-di-lavoro-abilitati";
        return HttpCalls::put($url,$data,"application/json",["Authorization: ".$this->authToken]);
    }

    public function putCentroDiLavoroMisurazione($data) {
        $url = $this->baseUrl."/centri-di-lavoro-misurazioni";
        return HttpCalls::put($url,$data,"application/json",["Authorization: ".$this->authToken]);
    }

    public function putCentriDiLavoroGruppo($data) {
        $url = $this->baseUrl."/centri-di-lavoro-gruppi";
        return HttpCalls::put($url,$data,"application/json",["Authorization: ".$this->authToken]);
    }

    public function putCentriDiLavoroGruppoCodice($data) {
        $url = $this->baseUrl."/centri-di-lavoro-gruppi-codice";
        return HttpCalls::put($url,$data,"application/json",["Authorization: ".$this->authToken]);
    }

    public function putNotificaInviata($data) {
        $url = $this->baseUrl."/notifiche-inviate";
        return HttpCalls::put($url,$data,"application/json",["Authorization: ".$this->authToken]);
    }

    public function putOrario($data) {
        $url = $this->baseUrl."/orari";
        return HttpCalls::put($url,$data,"application/json",["Authorization: ".$this->authToken]);
    }

    public function putOperatoreOrario($data) {
        $url = $this->baseUrl."/operatori-orari";
        return HttpCalls::put($url,$data,"application/json",["Authorization: ".$this->authToken]);
    }

    public function putCentroDiLavoroOrario($data) {
        $url = $this->baseUrl."/centri-di-lavoro-orari";
        return HttpCalls::put($url,$data,"application/json",["Authorization: ".$this->authToken]);
    }

    public function putOperatoreCosto($data) {
        $url = $this->baseUrl."/operatori-costo";
        return HttpCalls::put($url,$data,"application/json",["Authorization: ".$this->authToken]);
    }

    public function putCentroDiLavoroCosto($data) {
        $url = $this->baseUrl."/centri-di-lavoro-costo";
        return HttpCalls::put($url,$data,"application/json",["Authorization: ".$this->authToken]);
    }

    public function putTaskOperatoriAssegnati($data) {
        $url = $this->baseUrl."/task-operatori-assegnati";
        return HttpCalls::put($url,$data,"application/json",["Authorization: ".$this->authToken]);
    }

    public function putCentroDiLavoroSquadra($data) {
        $url = $this->baseUrl."/centri-di-lavoro-squadra";
        return HttpCalls::put($url,$data,"application/json",["Authorization: ".$this->authToken]);
    }

    public function putSquadreOperatori($data) {
        $url = $this->baseUrl."/squadre-operatori";
        return HttpCalls::put($url,$data,"application/json",["Authorization: ".$this->authToken]);
    }

    public function putEventoData($data) {
        $url = $this->baseUrl."/eventi-data";
        return HttpCalls::put($url,$data,"application/json",["Authorization: ".$this->authToken]);
    }

    public function putProtocolliMisurazioni($data) {
        $url = $this->baseUrl."/protocolli-misurazioni";
        return HttpCalls::put($url,$data,"application/json",["Authorization: ".$this->authToken]);
    }

    public function putCentriDiLavoroProtocolliMisurazioni($data) {
        $url = $this->baseUrl."/centri-di-lavoro-protocolli-misurazioni";
        return HttpCalls::put($url,$data,"application/json",["Authorization: ".$this->authToken]);
    }











    public function postSKillOperatori($data) {
        $url = $this->baseUrl."/skill-operatori";
        return HttpCalls::post($url,$data,"application/json",["Authorization: ".$this->authToken]); 
    }

    public function postCdlOperatori($data) {
        $url = $this->baseUrl."/centri-di-lavoro-operatori";
        return HttpCalls::post($url,$data,"application/json",["Authorization: ".$this->authToken]); 
    }

    public function postRuoloOperatori($data) {
        $url = $this->baseUrl."/ruoli-operatori";
        return HttpCalls::post($url,$data,"application/json",["Authorization: ".$this->authToken]); 
    }

    public function postCentroDiLavoroManutenzioneStorico($data) {
        $url = $this->baseUrl."/centri-di-lavoro-manutenzione-storico";
        return HttpCalls::post($url,$data,"application/json",["Authorization: ".$this->authToken]); 
    }

    public function postRepartoCentriDiLavoro($data) {
        $url = $this->baseUrl."/reparti-centri-di-lavoro";
        return HttpCalls::post($url,$data,"application/json",["Authorization: ".$this->authToken]); 
    }

    public function postRepartoOperatori($data) {
        $url = $this->baseUrl."/reparti-operatori";
        return HttpCalls::post($url,$data,"application/json",["Authorization: ".$this->authToken]); 
    }

    public function postGruppoCausaliSospensione($data) {
        $url = $this->baseUrl."/causali-sospensione-gruppi";
        return HttpCalls::post($url,$data,"application/json",["Authorization: ".$this->authToken]); 
    }

    public function postGruppoCausaliScarto($data) {
        $url = $this->baseUrl."/causali-scarto-gruppi";
        return HttpCalls::post($url,$data,"application/json",["Authorization: ".$this->authToken]); 
    }

    public function postEtichetta($data) {
        $url = $this->baseUrl."/etichette";
        return HttpCalls::post($url,$data,"application/json",["Authorization: ".$this->authToken]); 
    }

    public function postProduzioneLotto($data) {
        $url = $this->baseUrl."/lotti-produzione";
        return HttpCalls::post($url,$data,"application/json",["Authorization: ".$this->authToken]); 
    }

    public function postEventLog($data) {
        $url = $this->baseUrl."/eventi";
        return HttpCalls::post($url,$data,"application/json",["Authorization: ".$this->authToken]);
    }

    public function postTask($data) {
        $url = $this->baseUrl."/task";
        return HttpCalls::post($url,$data,"application/json",["Authorization: ".$this->authToken]); 
    }

    public function postWebhook($data) {
        $url = $this->baseUrl."/webhook";
        return HttpCalls::post($url,$data,"application/json",["Authorization: ".$this->authToken]);
    }

    public function postCentroDiLavoroStat($data) {
        $url = $this->baseUrl."/centri-di-lavoro-stato";
        return HttpCalls::post($url,$data,"application/json",["Authorization: ".$this->authToken]);
    }

    public function postTaskNote($data) {
        $url = $this->baseUrl."/task-note";
        return HttpCalls::post($url,$data,"application/json",["Authorization: ".$this->authToken]); 
    }

    public function postNotificaInviata($data) {
        $url = $this->baseUrl."/notifiche-inviate";
        return HttpCalls::post($url,$data,"application/json",["Authorization: ".$this->authToken]);
    }

    public function postOrario($data) {
        $url = $this->baseUrl."/orari";
        return HttpCalls::post($url,$data,"application/json",["Authorization: ".$this->authToken]);
    }

    public function postReparto($data) {
        $url = $this->baseUrl."/reparti";
        return HttpCalls::post($url,$data,"application/json",["Authorization: ".$this->authToken]);
    }

    public function postTurni($data) {
        $url = $this->baseUrl."/turni";
        return HttpCalls::post($url,$data,"application/json",["Authorization: ".$this->authToken]);
    }

    public function postSquadre($data) {
        $url = $this->baseUrl."/squadre";
        return HttpCalls::post($url,$data,"application/json",["Authorization: ".$this->authToken]);
    }










    public function deleteRunningTask($runningTaskId) {
        $data = [ "RunningTaskId" => $runningTaskId ];
        $url = $this->baseUrl."/running-task";
        return HttpCalls::delete($url,$data,"application/json",["Authorization: ".$this->authToken]);
    }

    public function deleteCentriDiLavoroIp($ip, $cdl = "") {
        $data = [ "Ip" => $ip, "CodiceCdl" => $cdl ];
        $url = $this->baseUrl."/centri-di-lavoro-ip";
        return HttpCalls::delete($url,$data,"application/json",["Authorization: ".$this->authToken]);
    }

    public function deleteDisintaBase($odl, $codiceArticolo = "", $codiceMateriale = "") {
        $data = ["CodiceOdl" => $odl, "CodiceArticolo" => $codiceArticolo, "CodiceMateriale" => $codiceMateriale];
        $url = $this->baseUrl."/distinta-base";
        return HttpCalls::delete($url,$data,"application/json",["Authorization: ".$this->authToken]);
    }

    public function deleteLotti($CodiceMateriale, $CodiceLotto = "") {
        $data = ["CodiceMateriale" => $CodiceMateriale, "CodiceLotto" => $CodiceLotto];
        $url = $this->baseUrl."/lotti";
        return HttpCalls::delete($url,$data,"application/json",["Authorization: ".$this->authToken]);
    }

    public function deleteGruppoScarto($CodiceGruppo) {
        $data = [ "CodiceGruppo" => $CodiceGruppo ];
        $url = $this->baseUrl."/causali-scarto-gruppi";
        return HttpCalls::delete($url,$data,"application/json",["Authorization: ".$this->authToken]);
    }

    public function deleteGruppoSospensione($CodiceGruppo) {
        $data = [ "CodiceGruppo" => $CodiceGruppo ];
        $url = $this->baseUrl."/causali-sospensione-gruppi";
        return HttpCalls::delete($url,$data,"application/json",["Authorization: ".$this->authToken]);
    }

    public function deleteReparto($Codice) {
        $data = [ "Codice" => $Codice ];
        $url = $this->baseUrl."/reparti";
        return HttpCalls::delete($url,$data,"application/json",["Authorization: ".$this->authToken]);
    }

    public function deleteRepartoOperatori($CodiceReparto) {
        $data = [ "CodiceReparto" => $CodiceReparto ];
        $url = $this->baseUrl."/reparti-operatori";
        return HttpCalls::delete($url,$data,"application/json",["Authorization: ".$this->authToken]);
    }

    public function deleteRepartoCentriDiLavoro($CodiceReparto) {
        $data = [ "CodiceReparto" => $CodiceReparto ];
        $url = $this->baseUrl."/reparti-centri-di-lavoro";
        return HttpCalls::delete($url,$data,"application/json",["Authorization: ".$this->authToken]);
    }

    public function deleteWebhook($id) {
        $data = [ "Id" => $id ];
        $url = $this->baseUrl."/webhook";
        return HttpCalls::delete($url,$data,"application/json",["Authorization: ".$this->authToken]);
    }

    public function deleteIfttt($id) {
        $data = [ "Id" => $id ];
        $url = $this->baseUrl."/ifttt";
        return HttpCalls::delete($url,$data,"application/json",["Authorization: ".$this->authToken]);
    }

    public function deleteCentriDiLavoroGruppi($CodiceGruppo) {
        $data = [ "CodiceGruppo" => $CodiceGruppo ];
        $url = $this->baseUrl."/centri-di-lavoro-gruppi";
        return HttpCalls::delete($url,$data,"application/json",["Authorization: ".$this->authToken]);
    }

    public function deleteRuolo($Codice) {
        $data = [ "CodiceRuolo" => $Codice ];
        $url = $this->baseUrl."/ruoli";
        return HttpCalls::delete($url,$data,"application/json",["Authorization: ".$this->authToken]);
    }

    public function deleteRuoloOperatori($CodiceRuolo = NULL,$CodiceOperatore = NULL) {
        if(!is_null($CodiceRuolo)) $data = [ "CodiceRuolo" => $CodiceRuolo ];
        elseif(!is_null($CodiceOperatore)) $data = [ "CodiceOperatore" => $CodiceOperatore ];
        $url = $this->baseUrl."/ruoli-operatori";
        return HttpCalls::delete($url,$data,"application/json",["Authorization: ".$this->authToken]);
    }

    public function deleteCdlOperatori($CodiceCdl) {
        $data = [ "CodiceCdl" => $CodiceCdl ];
        $url = $this->baseUrl."/centri-di-lavoro-operatori";
        return HttpCalls::delete($url,$data,"application/json",["Authorization: ".$this->authToken]);
    }

    public function deleteNotifica($codiceNotifica) {
        $data = [ "CodiceNotifica" => $codiceNotifica ];
        $url = $this->baseUrl."/notifiche";
        return HttpCalls::delete($url,$data,"application/json",["Authorization: ".$this->authToken]);
    }

    public function deleteOperatore($codiceOperatore) {
        $data = [ "CodiceOperatore" => $codiceOperatore ];
        $url = $this->baseUrl."/operatori";
        return HttpCalls::delete($url,$data,"application/json",["Authorization: ".$this->authToken]);
    }

    public function deleteSkill($Codice) {
        $data = [ "CodiceSkill" => $Codice ];
        $url = $this->baseUrl."/skill";
        return HttpCalls::delete($url,$data,"application/json",["Authorization: ".$this->authToken]);
    }

    public function deleteSkillOperatori($CodiceSkill = NULL,$CodiceOperatore = NULL) {
        if(!is_null($CodiceSkill)) $data = [ "CodiceSkill" => $CodiceSkill ];
        elseif(!is_null($CodiceOperatore)) $data = [ "CodiceOperatore" => $CodiceOperatore ];
        $url = $this->baseUrl."/skill-operatori";
        return HttpCalls::delete($url,$data,"application/json",["Authorization: ".$this->authToken]);
    }

    public function deleteOrario($Codice) {
        $data = [ "CodiceOrario" => $Codice ];
        $url = $this->baseUrl."/orari";
        return HttpCalls::delete($url,$data,"application/json",["Authorization: ".$this->authToken]);
    }

    public function deleteTurno($Codice) {
        $data = [ "CodiceTurno" => $Codice ];
        $url = $this->baseUrl."/turni";
        return HttpCalls::delete($url,$data,"application/json",["Authorization: ".$this->authToken]);
    }

    public function deleteSquadra($Codice) {
        $data = [ "CodiceSquadra" => $Codice ];
        $url = $this->baseUrl."/squadre";
        return HttpCalls::delete($url,$data,"application/json",["Authorization: ".$this->authToken]);
    }

    public function deleteProtocolliMisurazioni($id) {
        $data = [ "id" => $id ];
        $url = $this->baseUrl."/protocolli-misurazioni";
        return HttpCalls::delete($url,$data,"application/json",["Authorization: ".$this->authToken]);
    }

    public function deleteCentriDiLavoroProtocolliMisurazioni($id) {
        $data = [ "id" => $id ];
        $url = $this->baseUrl."/centri-di-lavoro-protocolli-misurazioni";
        return HttpCalls::delete($url,$data,"application/json",["Authorization: ".$this->authToken]);
    }

    public function deleteStoricoMisurazioniUltimi($date) {
        $data = [ "dateIso" => $date ];
        $url = $this->baseUrl."/storico-misurazioni-ultimi";
        return HttpCalls::delete($url,$data,"application/json",["Authorization: ".$this->authToken]);
    }

    public function deleteStoricoMisurazioniBufferItem($protocol,$item,$endpoint)
    {
        $data = ["protocol" => $protocol,"item" => $item,"endpoint" => $endpoint];
        $url = $this->baseUrl . "/storico-misurazioni-buffer-item";
        return HttpCalls::delete($url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function deleteStoricoMisurazioniBufferUltimi($date)
    {
        $data = ["dateIso" => $date];
        $url = $this->baseUrl . "/storico-misurazioni-buffer-ultimi";
        return HttpCalls::delete($url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }


    






    /**
     * da vedere
     */

    public function getUbicazione($ubicazione) {
        $url = $this->baseUrl."/getUbicazione/".$ubicazione;
        return HttpCalls::get($url,["Authorization: ".$this->authToken]);
    }

    public function getNumeroFigure($articolo) {
        $url = $this->baseUrl."/getNumeroFigure/".$articolo;
        return HttpCalls::get($url,["Authorization: ".$this->authToken]);
    }

    public function getQOrdQRes($id) {
        $url = $this->baseUrl."/getQOrdQRes/".$id;
        return HttpCalls::get($url,["Authorization: ".$this->authToken]);
    }

    public function getQProdottaScarto($id) {
        $url = $this->baseUrl."/getQProdottaScarto/".$id;
        return HttpCalls::get($url,["Authorization: ".$this->authToken]);
    }

    public function getConsegna($id) {
        $url = $this->baseUrl."/getConsegna/".$id;
        return HttpCalls::get($url,["Authorization: ".$this->authToken]);
    }

}


?>