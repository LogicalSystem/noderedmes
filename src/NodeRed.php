<?php

namespace LogicalSystem\NodeRed;

use LogicalSystem\HttpCalls\HttpCalls;

class NodeRed
{

    public $baseUrl;
    public $authToken;
    public $httpClass;

    public function __construct($baseUrl, $authToken, $httpClass = new HttpCalls)
    {
        $this->baseUrl = $baseUrl;
        $this->authToken = $authToken;
        $this->httpClass = $httpClass;
    }

    public function getUrloperatori($cod = 0)
    {
        if ($cod == 0) return $this->baseUrl . "/operatori";
        else return $this->baseUrl . "/operatori/cod/";
    }

    public function getUrlFasiTask()
    {
        return $this->baseUrl . "/fasi-task/odl/";
    }

    public function getUrlPutEvento()
    {
        return $this->baseUrl . "/eventi";
    }


    public function getCentriDiLavoro($cdl = NULL, $ip = NULL, $id = NULL, $codiceGruppo = NULL, $codiceSquadra = NULL)
    {
        if (!is_null($cdl)) $url = $this->baseUrl . "/centri-di-lavoro/cdl/" . $cdl;
        elseif (!is_null($ip)) $url = $this->baseUrl . "/centri-di-lavoro/ip/" . $ip;
        elseif (!is_null($id)) $url = $this->baseUrl . "/centri-di-lavoro/id/" . $id;
        elseif (!is_null($codiceGruppo)) $url = $this->baseUrl . "/centri-di-lavoro/gruppo/" . $codiceGruppo;
        elseif (!is_null($codiceSquadra)) $url = $this->baseUrl . "/centri-di-lavoro/squadra/" . $codiceSquadra;
        else $url = $this->baseUrl . "/centri-di-lavoro";
        return call_user_func([$this->httpClass, "get"], $url, ["Authorization: " . $this->authToken]);
    }


    public function getCentriDiLavoroRaw($id = NULL, $codiceCdl = NULL)
    {
        if (!is_null($codiceCdl)) $url = $this->baseUrl . "/centri-di-lavoro-raw/cdl/" . $codiceCdl;
        elseif (!is_null($id)) $url = $this->baseUrl . "/centri-di-lavoro-raw/id/" . $id;
        else $url = $this->baseUrl . "/centri-di-lavoro-raw";
        return call_user_func([$this->httpClass, "get"], $url, ["Authorization: " . $this->authToken]);
    }



    public function getOrdiniDiLavoro($odl = NULL, $task = NULL)
    {
        if (!is_null($task)) $url = $this->baseUrl . "/ordini-di-lavoro/task/" . $task;
        elseif (!is_null($odl)) $url = $this->baseUrl . "/ordini-di-lavoro/odl/" . urlencode($odl);
        else $url = $this->baseUrl . "/ordini-di-lavoro";
        return call_user_func([$this->httpClass, "get"], $url, ["Authorization: " . $this->authToken]);
    }



    public function getOperatori($cod = NULL, $pin = NULL, $id = NULL)
    {
        if (!is_null($cod)) $url = $this->baseUrl . "/operatori/cod/" . $cod;
        elseif (!is_null($pin)) $url = $this->baseUrl . "/operatori/pin/" . $pin;
        elseif (!is_null($id)) $url = $this->baseUrl . "/operatori/id/" . $id;
        else $url = $this->baseUrl . "/operatori";
        return call_user_func([$this->httpClass, "get"], $url, ["Authorization: " . $this->authToken]);
    }


    public function getOrdiniDiLavoroPossibili($cdl, $odl = NULL)
    {
        if (is_null($odl)) $url = $this->baseUrl . "/ordini-di-lavoroPossibili/cdl/" . $cdl;
        else $url = $this->baseUrl . "/ordini-di-lavoroPossibili/cdl/" . $cdl . "/odl/" . urlencode($odl);
        return call_user_func([$this->httpClass, "get"], $url, ["Authorization: " . $this->authToken]);
    }


    public function getFasi($task = NULL, $cod = NULL, $codiceOdl = NULL)
    {
        if (!is_null($task)) $url = $this->baseUrl . "/fasi/task/" . $task;
        elseif (!is_null($cod)) $url = $this->baseUrl . "/fasi/cod/" . urlencode($cod);
        elseif (!is_null($codiceOdl)) $url = $this->baseUrl . "/fasi/odl/" . urlencode($codiceOdl);
        else $url = $this->baseUrl . "/fasi";
        return call_user_func([$this->httpClass, "get"], $url, ["Authorization: " . $this->authToken]);
    }


    // fasi dell'ordine del lavoro, sulla macchina, che siano tra i task
    public function getFasiTask($odl, $cdl)
    {
        $url = $this->getUrlFasiTask() . $odl . "/cdl/" . $cdl;
        return call_user_func([$this->httpClass, "get"], $url, ["Authorization: " . $this->authToken]);
    }


    public function getArticoli($articolo = NULL)
    {
        if (is_null($articolo)) $url = $this->baseUrl . "/articoli";
        else $url = $this->baseUrl . "/articoli/cod/" . urlencode($articolo);
        return call_user_func([$this->httpClass, "get"], $url, ["Authorization: " . $this->authToken]);
    }


    public function getTask($id = NULL, $odl = NULL, $cdl = NULL, $parentTask = NULL, $fase = NULL, $codiceOperatore = NULL, $codiceNesting = NULL)
    {
        if (!is_null($id)) $url = $this->baseUrl . "/task/id/" . $id;
        elseif (!is_null($odl) && !is_null($fase)) $url = $this->baseUrl . "/task/odl/" . urlencode($odl) . "/fase/" . urlencode($fase);
        elseif (!is_null($odl) && !is_null($cdl)) $url = $this->baseUrl . "/task/odl/" . urlencode($odl) . "/cdl/" . $cdl;
        elseif (!is_null($cdl)) $url = $this->baseUrl . "/task/cdl/" . $cdl;
        elseif (!is_null($odl)) $url = $this->baseUrl . "/task/odl/" . urlencode($odl);
        elseif (!is_null($parentTask)) $url = $this->baseUrl . "/task/parent/" . $parentTask;
        elseif (!is_null($codiceOperatore)) $url = $this->baseUrl . "/task/op/" . $codiceOperatore;
        elseif(!is_null($codiceNesting)) $url = $this->baseUrl."/task/nesting/".$codiceNesting;
        else $url = $this->baseUrl . "/task";
        return call_user_func([$this->httpClass, "get"], $url, ["Authorization: " . $this->authToken]);
    }


    public function getTaskRaw($id = NULL, $odl = NULL, $cdl = NULL, $parentTask = NULL, $fase = NULL, $codiceOperatore = NULL)
    {
        if (!is_null($id)) $url = $this->baseUrl . "/task-raw/id/" . $id;
        elseif (!is_null($odl) && !is_null($fase)) $url = $this->baseUrl . "/task-raw/odl/" . urlencode($odl) . "/fase/" . urlencode($fase);
        elseif (!is_null($odl) && !is_null($cdl)) $url = $this->baseUrl . "/task-raw/odl/" . urlencode($odl) . "/cdl/" . $cdl;
        elseif (!is_null($cdl)) $url = $this->baseUrl . "/task-raw/cdl/" . $cdl;
        elseif (!is_null($odl)) $url = $this->baseUrl . "/task-raw/odl/" . urlencode($odl);
        elseif (!is_null($parentTask)) $url = $this->baseUrl . "/task-raw/parent/" . $parentTask;
        elseif (!is_null($codiceOperatore)) $url = $this->baseUrl . "/task-raw/op/" . $codiceOperatore;
        else $url = $this->baseUrl . "/task-raw";
        return call_user_func([$this->httpClass, "get"], $url, ["Authorization: " . $this->authToken]);
    }

    public function getRunningTask($task = NULL, $cdl = NULL, $id = NULL, $codiceOdl = NULL, $codiceOperatore = NULL)
    {
        if (!is_null($task) && !is_null($cdl)) $url = $this->baseUrl . "/running-task/task/" . $task . "/cdl/" . $cdl;
        elseif (!is_null($cdl)) $url = $this->baseUrl . "/running-task/cdl/" . $cdl;
        elseif (!is_null($task)) $url = $this->baseUrl . "/running-task/task/" . $task;
        elseif (!is_null($id)) $url = $this->baseUrl . "/running-task/id/" . $id;
        elseif (!is_null($codiceOdl)) $url = $this->baseUrl . "/running-task/odl/" . $codiceOdl;
        elseif (!is_null($codiceOperatore)) $url = $this->baseUrl . "/running-task/operatore/" . $codiceOperatore;
        else $url = $this->baseUrl . "/running-task";
        return call_user_func([$this->httpClass, "get"], $url, ["Authorization: " . $this->authToken]);
    }

    public function getUltimoEvento($task = NULL, $cdl = NULL)
    {
        if (!is_null($task)) $url = $this->baseUrl . "/ultimo-evento/task/" . $task;
        elseif (!is_null($cdl)) $url = $this->baseUrl . "/ultimo-evento/cdl/" . $cdl;
        return call_user_func([$this->httpClass, "get"], $url, ["Authorization: " . $this->authToken]);
    }

    public function getCausaliSospensione($cod = NULL, $gruppo = NULL)
    {
        if (!is_null($cod)) $url = $this->baseUrl . "/causali-sospensione/cod/" . $cod;
        elseif (!is_null($gruppo)) $url = $this->baseUrl . "/causali-sospensione/gruppo/" . $gruppo;
        else $url = $this->baseUrl . "/causali-sospensione";
        return call_user_func([$this->httpClass, "get"], $url, ["Authorization: " . $this->authToken]);
    }

    public function getCausaliScarto($cod = NULL, $gruppo = NULL)
    {
        if (!is_null($cod)) $url = $this->baseUrl . "/causali-scarto/cod/" . $cod;
        elseif (!is_null($gruppo)) $url = $this->baseUrl . "/causali-scarto/gruppo/" . $gruppo;
        else $url = $this->baseUrl . "/causali-scarto";
        return call_user_func([$this->httpClass, "get"], $url, ["Authorization: " . $this->authToken]);
    }

    public function getEventi($id = NULL, $task = NULL, $evento = NULL, $cdl = NULL, $startDate = NULL, $runningTaskId = NULL, $codiceOperatore = NULL)
    {
        if (!is_null($task) && !is_null($evento)) $url = $this->baseUrl . "/eventi/task/" . $task . "/evento/" . $evento;
        elseif (!is_null($task) && !is_null($startDate)) $url = $this->baseUrl . "/eventi/task/" . $task . "/startdate/" . $startDate;
        elseif (!is_null($cdl) && !is_null($startDate)) $url = $this->baseUrl . "/eventi/cdl/" . $cdl . "/startdate/" . $startDate;
        elseif (!is_null($task)) $url = $this->baseUrl . "/eventi/task/" . $task;
        elseif (!is_null($runningTaskId) && !is_null($evento)) $url = $this->baseUrl . "/eventi/running-task/" . $runningTaskId . "/evento/" . $evento;
        elseif (!is_null($runningTaskId)) $url = $this->baseUrl . "/eventi/running-task/" . $runningTaskId;
        elseif (!is_null($evento)) $url = $this->baseUrl . "/eventi/evento/" . $evento;
        elseif (!is_null($cdl)) $url = $this->baseUrl . "/eventi/cdl/" . $cdl;
        elseif (!is_null($codiceOperatore)) $url = $this->baseUrl . "/eventi/operatore/" . $codiceOperatore;
        elseif (!is_null($id)) $url = $this->baseUrl . "/eventi/id/" . $id;
        else $url = $this->baseUrl . "/eventi";
        return call_user_func([$this->httpClass, "get"], $url, ["Authorization: " . $this->authToken]);
    }

    public function getTipiEventi($cod = NULL)
    {
        if (!is_null($cod)) $url = $this->baseUrl . "/tipi-eventi/cod/" . $cod;
        else $url = $this->baseUrl . "/tipi-eventi";
        return call_user_func([$this->httpClass, "get"], $url, ["Authorization: " . $this->authToken]);
    }

    public function getStoricoEventi($id = NULL, $cdl = NULL, $taskId = NULL, $codiceOdl = NULL)
    {
        if (!is_null($cdl)) $url = $this->baseUrl . "/storico-eventi/cdl/" . $cdl;
        elseif (!is_null($taskId)) $url = $this->baseUrl . "/storico-eventi/task/" . $taskId;
        elseif (!is_null($id)) $url = $this->baseUrl . "/storico-eventi/id/" . $id;
        elseif (!is_null($codiceOdl)) $url = $this->baseUrl . "/storico-eventi/odl/" . $codiceOdl;
        else $url = $this->baseUrl . "/storico-eventi";
        return call_user_func([$this->httpClass, "get"], $url, ["Authorization: " . $this->authToken]);
    }

    public function getTaskScarti($task = NULL, $cod = NULL, $runningTaskId = NULL)
    {
        if (!is_null($task) && !is_null($cod)) $url = $this->baseUrl . "/task-scarti/task/" . $task . "/cod/" . $cod;
        elseif (!is_null($runningTaskId) && !is_null($cod)) $url = $this->baseUrl . "/task-scarti/running-task/" . $runningTaskId . "/cod/" . $cod;
        elseif (!is_null($task)) $url = $this->baseUrl . "/task-scarti/task/" . $task;
        elseif (!is_null($cod)) $url = $this->baseUrl . "/task-scarti/cod/" . $cod;
        elseif (!is_null($runningTaskId)) $url = $this->baseUrl . "/task-scarti/running-task/" . $runningTaskId;
        else $url = $this->baseUrl . "/task-scarti";
        return call_user_func([$this->httpClass, "get"], $url, ["Authorization: " . $this->authToken]);
    }

    public function getCentriDiLavoroIp($codiceCdl = NULL, $ip = NULL)
    {
        if (!is_null($codiceCdl)) $url = $this->baseUrl . "/centri-di-lavoro-ip/cdl/" . $codiceCdl;
        if (!is_null($ip)) $url = $this->baseUrl . "/centri-di-lavoro-ip/ip/" . $ip;
        else $url = $this->baseUrl . "/centri-di-lavoro-ip";
        return call_user_func([$this->httpClass, "get"], $url, ["Authorization: " . $this->authToken]);
    }

    public function getDistintaBase($codart = NULL, $odl = NULL, $id = NULL, $mat = NULL, $alt = "false", $codiceFase = NULL, $codiceNesting = NULL, $tipologiaMateriale = NULL)
    {
        if (!is_null($mat) && !is_null($odl) && !is_null($codiceFase)) $url = $this->baseUrl . "/distinta-base/mat/" . urlencode($mat) . "/odl/" . urlencode($odl) . "/fase/" . urlencode($codiceFase);
        elseif (!is_null($mat) && !is_null($odl)) $url = $this->baseUrl . "/distinta-base/mat/" . urlencode($mat) . "/odl/" . urlencode($odl);
        elseif (!is_null($mat) && !is_null($codiceNesting)) $url = $this->baseUrl . "/distinta-base/codice-nesting/" . urlencode($codiceNesting) . "/mat/" . urlencode($mat);
        elseif (!is_null($mat) && !is_null($tipologiaMateriale)) $url = $this->baseUrl . "/distinta-base/codice-nesting/" . $codiceNesting . "/tipologia-materiale/" . urlencode($tipologiaMateriale);
        elseif (!is_null($codiceFase) && !is_null($odl)) $url = $this->baseUrl . "/distinta-base/odl/" . urlencode($odl) . "/fase/" . urlencode($codiceFase);
        elseif (!is_null($codart)) $url = $this->baseUrl . "/distinta-base/cod/" . $codart . "/alt/" . $alt;
        elseif (!is_null($odl)) $url = $this->baseUrl . "/distinta-base/odl/" . urlencode($odl) . "/alt/" . $alt;
        elseif (!is_null($id)) $url = $this->baseUrl . "/distinta-base/id/" . $id;
        elseif (!is_null($codiceNesting)) $url = $this->baseUrl . "/distinta-base/codice-nesting/" . urlencode($codiceNesting);
        elseif (!is_null($tipologiaMateriale)) $url = $this->baseUrl . "/distinta-base/tipologia-materiale/" . urlencode($tipologiaMateriale);
        else $url = $this->baseUrl . "/distinta-base";
        return call_user_func([$this->httpClass, "get"], $url, ["Authorization: " . $this->authToken]);
    }

    public function getLotti($codl = NULL, $codm = NULL, $tipologiaMateriale = NULL)
    {
        if (!is_null($codl) && !is_null($codm)) $url = $this->baseUrl . "/lotti/codice-lotto/" . urlencode($codl) . "/codice-materiale/" . urlencode($codm);
        if (!is_null($codl) && !is_null($tipologiaMateriale)) $url = $this->baseUrl . "/lotti/codice-lotto/" . urlencode($codl) . "/tipologia-materiale/" . urlencode($tipologiaMateriale);
        elseif (!is_null($codl)) $url = $this->baseUrl . "/lotti/codice-lotto/" . urlencode($codl);
        elseif (!is_null($codm)) $url = $this->baseUrl . "/lotti/codice-materiale/" . urlencode($codm);
        elseif (!is_null($tipologiaMateriale)) $url = $this->baseUrl . "/lotti/tipologia-materiale/" . urlencode($tipologiaMateriale);
        else $url = $this->baseUrl . "/lotti";
        return call_user_func([$this->httpClass, "get"], $url, ["Authorization: " . $this->authToken]);
    }

    public function getDistintaBaseUsata($id = NULL, $runningTask = NULL, $task = NULL, $distintaId = NULL, $codiceOdl = NULL, $stornoIdRef = NULL)
    {
        if (!is_null($id)) $url = $this->baseUrl . "/distinta-base-usata/id/" . $id;
        elseif (!is_null($task)) $url = $this->baseUrl . "/distinta-base-usata/task/" . $task;
        elseif (!is_null($distintaId)) $url = $this->baseUrl . "/distinta-base-usata/distinta/" . $distintaId;
        elseif (!is_null($codiceOdl)) $url = $this->baseUrl . "/distinta-base-usata/odl/" . $codiceOdl;
        elseif (!is_null($runningTask)) $url = $this->baseUrl . "/distinta-base-usata/rtask/" . $runningTask;
        elseif (!is_null($stornoIdRef)) $url = $this->baseUrl . "/distinta-base-usata/ref-id/" . $stornoIdRef;
        else $url = $this->baseUrl . "/distinta-base-usata";
        return HttpCalls::get($url, ["Authorization: " . $this->authToken]);
    }

    public function getOperatoriEventi($cdl = NULL, $op = NULL)
    {
        if (!is_null($cdl) && !is_null($op)) $url = $this->baseUrl . "/operatori-eventi/cdl/" . $cdl . "/op/" . $op;
        elseif (!is_null($cdl)) $url = $this->baseUrl . "/operatori-eventi/cdl/" . $cdl;
        elseif (!is_null($op)) $url = $this->baseUrl . "/operatori-eventi/op/" . $op;
        else $url = $this->baseUrl . "/operatori-eventi";
        return call_user_func([$this->httpClass, "get"], $url, ["Authorization: " . $this->authToken]);
    }

    public function getDistintaBaseAlternativi($odl, $mat)
    {
        if (!is_null($mat) && !is_null($odl)) $url = $this->baseUrl . "/distinta-base-alternativi/mat/" . $mat . "/odl/" . $odl;
        else $url = $this->baseUrl . "/distinta-base-alternativi";
        return call_user_func([$this->httpClass, "get"], $url, ["Authorization: " . $this->authToken]);
    }

    public function getDistintaBasePadre($odl, $mat)
    {
        if (!is_null($mat) && !is_null($odl)) $url = $this->baseUrl . "/distinta-base-padre/mat/" . $mat . "/odl/" . $odl;
        else $url = $this->baseUrl . "/distinta-base-padre";
        return call_user_func([$this->httpClass, "get"], $url, ["Authorization: " . $this->authToken]);
    }

    public function getGruppiCausaliSospensione($cod = NULL)
    {
        if (!is_null($cod)) $url = $this->baseUrl . "/causali-sospensione-gruppi/cod/" . $cod;
        else $url = $this->baseUrl . "/causali-sospensione-gruppi";
        return call_user_func([$this->httpClass, "get"], $url, ["Authorization: " . $this->authToken]);
    }

    public function getGruppiCausaliScarto($cod = NULL)
    {
        if (!is_null($cod)) $url = $this->baseUrl . "/causali-scarto-gruppi/cod/" . $cod;
        else $url = $this->baseUrl . "/causali-scarto-gruppi";
        return call_user_func([$this->httpClass, "get"], $url, ["Authorization: " . $this->authToken]);
    }

    public function getReparti($cod = NULL)
    {
        if (!is_null($cod)) $url = $this->baseUrl . "/reparti/cod/" . $cod;
        else $url = $this->baseUrl . "/reparti";
        return call_user_func([$this->httpClass, "get"], $url, ["Authorization: " . $this->authToken]);
    }

    public function getRepartoOperatori($codReparto = NULL)
    {
        if (!is_null($codReparto)) $url = $this->baseUrl . "/reparti-operatori/cod/" . $codReparto;
        else $url = $this->baseUrl . "/reparti-operatori";
        return call_user_func([$this->httpClass, "get"], $url, ["Authorization: " . $this->authToken]);
    }

    public function getRepartoCentriDiLavoro($codReparto = NULL, $codCdl = NULL)
    {
        if (!is_null($codReparto) && !is_null($codCdl)) $url = $this->baseUrl . "/reparti-centri-di-lavoro/cod/" . $codReparto . "/codcdl/" . $codCdl;
        elseif (!is_null($codReparto)) $url = $this->baseUrl . "/reparti-centri-di-lavoro/cod/" . $codReparto;
        elseif (!is_null($codCdl)) $url = $this->baseUrl . "/reparti-centri-di-lavoro/codcdl/" . $codCdl;
        else $url = $this->baseUrl . "/reparti-centri-di-lavoro";
        return call_user_func([$this->httpClass, "get"], $url, ["Authorization: " . $this->authToken]);
        var_dump($url);
    }

    public function getTaskToDo($cdl, $ntask = 5)
    {
        $url = $this->baseUrl . "/task-to-do/cdl/" . $cdl . "/ntask/" . $ntask;
        return call_user_func([$this->httpClass, "get"], $url, ["Authorization: " . $this->authToken]);
    }

    public function getTaskToDoRaw($cdl, $ntask = 5)
    {
        $url = $this->baseUrl . "/task-to-do-raw/cdl/" . $cdl . "/ntask/" . $ntask;
        return call_user_func([$this->httpClass, "get"], $url, ["Authorization: " . $this->authToken]);
    }

    public function getCentroDiLavoroStato($cdl = NULL)
    {
        if (!is_null($cdl)) $url = $this->baseUrl . "/centri-di-lavoro-stato/cdl/" . $cdl;
        else $url = $this->baseUrl . "/centri-di-lavoro-stato";
        return call_user_func([$this->httpClass, "get"], $url, ["Authorization: " . $this->authToken]);
    }

    public function getEtichette($codiceEtichetta = NULL, $taskid = NULL, $tipo = NULL)
    {
        if (!is_null($codiceEtichetta)) $url = $this->baseUrl . "/etichette/codice/" . $codiceEtichetta;
        elseif (!is_null($taskid) && !is_null($tipo)) $url = $this->baseUrl . "/etichette/task/" . $taskid . "/tipo/" . $tipo;
        elseif (!is_null($taskid)) $url = $this->baseUrl . "/etichette/task/" . $taskid;
        elseif (!is_null($tipo)) $url = $this->baseUrl . "/etichette/tipo/" . $tipo;
        else $url = $this->baseUrl . "/etichette";
        return call_user_func([$this->httpClass, "get"], $url, ["Authorization: " . $this->authToken]);
    }

    public function getImballi($codiceImballo = NULL, $tipo = NULL)
    {
        if (!is_null($codiceImballo)) $url = $this->baseUrl . "/imballi/codice/" . $codiceImballo;
        elseif (!is_null($tipo)) $url = $this->baseUrl . "/imballi/tipo/" . $tipo;
        else $url = $this->baseUrl . "/imballi";
        return call_user_func([$this->httpClass, "get"], $url, ["Authorization: " . $this->authToken]);
    }

    public function getAttrezzature($codiceAttrezzatura = NULL, $codiceOdl = NULL, $codiceFase = NULL)
    {
        if (!is_null($codiceAttrezzatura) && !is_null($codiceOdl) && !is_null($codiceFase)) $url = $this->baseUrl . "/attrezzature/codice/" . $codiceAttrezzatura . "/odl/" . urlencode($codiceOdl) . "/fase/" . $codiceFase;
        elseif (!is_null($codiceOdl) && !is_null($codiceFase)) $url = $this->baseUrl . "/attrezzature/odl/" . urlencode($codiceOdl) . "/fase/" . urlencode($codiceFase);
        elseif (!is_null($codiceAttrezzatura)) $url = $this->baseUrl . "/attrezzature/codice/" . $codiceAttrezzatura;
        elseif (!is_null($codiceOdl)) $url = $this->baseUrl . "/attrezzature/odl/" . urlencode($codiceOdl);
        elseif (!is_null($codiceFase)) $url = $this->baseUrl . "/attrezzature/fase/" . urlencode($codiceFase);
        else $url = $this->baseUrl . "/attrezzature";
        return call_user_func([$this->httpClass, "get"], $url, ["Authorization: " . $this->authToken]);
    }

    public function getWebhook($id = NULL, $codiceEvento = NULL)
    {
        if (!is_null($id)) $url = $this->baseUrl . "/webhook/id/" . $id;
        elseif (!is_null($codiceEvento)) $url = $this->baseUrl . "/webhook/codice/" . $codiceEvento;
        else $url = $this->baseUrl . "/webhook";
        return call_user_func([$this->httpClass, "get"], $url, ["Authorization: " . $this->authToken]);
    }

    public function getLottiProduzione($id = NULL, $taskId = NULL, $stepTask = NULL, $codiceOdl = NULL, $codiceFase = NULL)
    {
        if (!is_null($id)) $url = $this->baseUrl . "/lotti-produzione/id/" . $id;
        elseif (!is_null($codiceOdl) && !is_null($stepTask) && !is_null($codiceFase)) $url = $this->baseUrl . "/lotti-produzione/odl/" . $codiceOdl . "/fase/" . $codiceFase . "/step/" . $stepTask;
        elseif (!is_null($codiceOdl) && !is_null($stepTask)) $url = $this->baseUrl . "/lotti-produzione/odl/" . $codiceOdl . "/step/" . $stepTask;
        elseif (!is_null($codiceOdl)) $url = $this->baseUrl . "/lotti-produzione/odl/" . $codiceOdl;
        elseif (!is_null($taskId)) $url = $this->baseUrl . "/lotti-produzione/task/" . $taskId;
        else $url = $this->baseUrl . "/lotti-produzione";
        return call_user_func([$this->httpClass, "get"], $url, ["Authorization: " . $this->authToken]);
    }


    public function getLottiAttrezzature($coda = NULL, $identificativo = NULL)
    {
        if (!is_null($coda)) $url = $this->baseUrl . "/attrezzature-lotti/codice-attrezzatura/" . $coda;
        elseif (!is_null($identificativo)) $url = $this->baseUrl . "/attrezzature-lotti/identificativo/" . $identificativo;
        else $url = $this->baseUrl . "/attrezzature-lotti";
        return call_user_func([$this->httpClass, "get"], $url, ["Authorization: " . $this->authToken]);
    }

    public function getAttrezzaturaUsata($runningTask = NULL, $task = NULL, $codiceAttrezzatura = NULL)
    {
        if (!is_null($task)) $url = $this->baseUrl . "/attrezzature-usate/task/" . $task;
        elseif (!is_null($runningTask) && !is_null($codiceAttrezzatura)) $url = $this->baseUrl . "/attrezzature-usate/rtask/" . $runningTask . "/coda/" . $codiceAttrezzatura;
        elseif (!is_null($runningTask)) $url = $this->baseUrl . "/attrezzature-usate/rtask/" . $runningTask;
        elseif (!is_null($codiceAttrezzatura)) $url = $this->baseUrl . "/attrezzature-usate/coda/" . $codiceAttrezzatura;
        else $url = $this->baseUrl . "/attrezzature-usate";
        return call_user_func([$this->httpClass, "get"], $url, ["Authorization: " . $this->authToken]);
    }

    public function getAttrezzaturaUsataValutazione($id = NULL, $attrezzaturaUsataId = NULL)
    {
        if (!is_null($id)) $url = $this->baseUrl . "/attrezzature-usate-valutazione/id/" . $id;
        elseif (!is_null($attrezzaturaUsataId)) $url = $this->baseUrl . "/attrezzature-usate-valutazione/attrusid/" . $attrezzaturaUsataId;
        else $url = $this->baseUrl . "/attrezzature-usate-valutazione";
        return call_user_func([$this->httpClass, "get"], $url, ["Authorization: " . $this->authToken]);
    }

    public function getCentroDiLavoroManutenzione($cdl = NULL)
    {
        if (!is_null($cdl)) $url = $this->baseUrl . "/centri-di-lavoro-manutenzione/cdl/" . $cdl;
        else $url = $this->baseUrl . "/centri-di-lavoro-manutenzione";
        return call_user_func([$this->httpClass, "get"], $url, ["Authorization: " . $this->authToken]);
    }

    public function getCentroDiLavoroManutenzioneStorico($cdl = NULL, $tipo = NULL)
    {
        if (!is_null($cdl) && !is_null($tipo)) $url = $this->baseUrl . "/centri-di-lavoro-manutenzione-storico/cdl/" . $cdl . "/tipo/" . $tipo;
        elseif (!is_null($cdl)) $url = $this->baseUrl . "/centri-di-lavoro-manutenzione-storico/cdl/" . $cdl;
        elseif (!is_null($tipo)) $url = $this->baseUrl . "/centri-di-lavoro-manutenzione-storico/tipo/" . $tipo;
        else $url = $this->baseUrl . "/centri-di-lavoro-manutenzione-storico";
        return call_user_func([$this->httpClass, "get"], $url, ["Authorization: " . $this->authToken]);
    }

    public function getAttivitaExtra($codice = NULL)
    {
        if (!is_null($codice)) $url = $this->baseUrl . "/attivita-extra/cod/" . $codice;
        else $url = $this->baseUrl . "/attivita-extra";
        return call_user_func([$this->httpClass, "get"], $url, ["Authorization: " . $this->authToken]);
    }

    public function getAttivitaTask($codice = NULL, $taskId = NULL)
    {
        if (!is_null($codice)) $url = $this->baseUrl . "/attivita-task/cod/" . $codice;
        elseif (!is_null($taskId)) $url = $this->baseUrl . "/attivita-task/task/" . $taskId;
        else $url = $this->baseUrl . "/attivita-task";
        return call_user_func([$this->httpClass, "get"], $url, ["Authorization: " . $this->authToken]);
    }

    public function getIfttt($id = NULL, $codiceCdl = NULL)
    {
        if (!is_null($id)) $url = $this->baseUrl . "/ifttt/id/" . $id;
        elseif (!is_null($codiceCdl)) $url = $this->baseUrl . "/ifttt/cod/" . $codiceCdl;
        else $url = $this->baseUrl . "/ifttt";
        return call_user_func([$this->httpClass, "get"], $url, ["Authorization: " . $this->authToken]);
    }

    public function getIftttEventi($id = NULL, $codiceCdl = NULL)
    {
        if (!is_null($id)) $url = $this->baseUrl . "/ifttt-eventi/id/" . $id;
        elseif (!is_null($codiceCdl)) $url = $this->baseUrl . "/ifttt-eventi/cod/" . $codiceCdl;
        else $url = $this->baseUrl . "/ifttt-eventi";
        return call_user_func([$this->httpClass, "get"], $url, ["Authorization: " . $this->authToken]);
    }

    public function getSfrido($taskId = NULL, $codiceMateriale = NULL, $codiceCausale = NULL)
    {
        if (!is_null($taskId) && !is_null($codiceMateriale) && !is_null($codiceCausale)) $url = $this->baseUrl . "/sfrido/task/" . $taskId . "/mat/" . $codiceMateriale . "/cau/" . $codiceCausale;
        elseif (!is_null($taskId) && !is_null($codiceMateriale)) $url = $this->baseUrl . "/sfrido/task/" . $taskId . "/mat/" . $codiceMateriale;
        elseif (!is_null($taskId)) $url = $this->baseUrl . "/sfrido/task/" . $taskId;
        elseif (!is_null($codiceMateriale)) $url = $this->baseUrl . "/sfrido/mat/" . $codiceMateriale;
        elseif (!is_null($codiceCausale)) $url = $this->baseUrl . "/sfrido/cau/" . $codiceCausale;
        else $url = $this->baseUrl . "/sfrido";
        return call_user_func([$this->httpClass, "get"], $url, ["Authorization: " . $this->authToken]);
    }

    public function getCentriDiLavoroProcessi($codiceCdl = NULL, $processName = NULL)
    {
        if (!is_null($codiceCdl)) $url = $this->baseUrl . "/centri-di-lavoro-processi/cdl/" . $codiceCdl;
        elseif (!is_null($processName)) $url = $this->baseUrl . "/centri-di-lavoro-processi/process/" . $processName;
        else $url = $this->baseUrl . "/centri-di-lavoro-processi";
        return call_user_func([$this->httpClass, "get"], $url, ["Authorization: " . $this->authToken]);
    }

    public function getTaskNote($taskId = NULL, $runningTaskId = NULL)
    {
        if (!is_null($taskId)) $url = $this->baseUrl . "/task-note/task/" . $taskId;
        elseif (!is_null($runningTaskId)) $url = $this->baseUrl . "/task-note/rt/" . $runningTaskId;
        else $url = $this->baseUrl . "/task-note";
        return call_user_func([$this->httpClass, "get"], $url, ["Authorization: " . $this->authToken]);
    }

    public function getCentriDiLavoroGruppi($cod = NULL)
    {
        if (!is_null($cod)) $url = $this->baseUrl . "/centri-di-lavoro-gruppi/cod/" . $cod;
        else $url = $this->baseUrl . "/centri-di-lavoro-gruppi";
        return call_user_func([$this->httpClass, "get"], $url, ["Authorization: " . $this->authToken]);
    }

    public function getCausaliEventi($cdl = NULL, $codiceCausale = NULL)
    {
        if (!is_null($cdl) && !is_null($codiceCausale)) $url = $this->baseUrl . "/causali-eventi/cdl/" . $cdl . "/cau/" . $codiceCausale;
        elseif (!is_null($cdl)) $url = $this->baseUrl . "/causali-eventi/cdl/" . $cdl;
        elseif (!is_null($codiceCausale)) $url = $this->baseUrl . "/causali-eventi/cau/" . $codiceCausale;
        else $url = $this->baseUrl . "/causali-eventi";
        return call_user_func([$this->httpClass, "get"], $url, ["Authorization: " . $this->authToken]);
    }

    public function getRuoli($cod = NULL)
    {
        if (!is_null($cod)) $url = $this->baseUrl . "/ruoli/cod/" . $cod;
        else $url = $this->baseUrl . "/ruoli";
        return call_user_func([$this->httpClass, "get"], $url, ["Authorization: " . $this->authToken]);
    }

    public function getRuoloOperatori($codRuolo = NULL, $codiceOperatore = NULL)
    {
        if (!is_null($codRuolo)) $url = $this->baseUrl . "/ruoli-operatori/cod/" . $codRuolo;
        elseif (!is_null($codiceOperatore)) $url = $this->baseUrl . "/ruoli-operatori/op/" . $codiceOperatore;
        else $url = $this->baseUrl . "/ruoli-operatori";
        return call_user_func([$this->httpClass, "get"], $url, ["Authorization: " . $this->authToken]);
    }

    public function getCdlOperatori($codiceCdl = NULL, $codiceOperatore = NULL)
    {
        if (!is_null($codiceCdl)) $url = $this->baseUrl . "/centri-di-lavoro-operatori/cod/" . $codiceCdl;
        elseif (!is_null($codiceOperatore)) $url = $this->baseUrl . "/centri-di-lavoro-operatori/op/" . $codiceOperatore;
        else $url = $this->baseUrl . "/centri-di-lavoro-operatori";
        return call_user_func([$this->httpClass, "get"], $url, ["Authorization: " . $this->authToken]);
    }

    public function getNotifiche($id = NULL, $codiceNotifica = NULL, $codiceEvento = NULL)
    {
        if (!is_null($codiceNotifica)) $url = $this->baseUrl . "/notifiche/cod/" . $codiceNotifica;
        elseif (!is_null($codiceEvento)) $url = $this->baseUrl . "/notifiche/evento/" . $codiceEvento;
        else $url = $this->baseUrl . "/notifiche";
        return call_user_func([$this->httpClass, "get"], $url, ["Authorization: " . $this->authToken]);
    }

    public function getNotificheInviate($id = NULL, $codiceNotifica = NULL, $codiceOperatore = NULL)
    {
        if (!is_null($codiceNotifica)) $url = $this->baseUrl . "/notifiche-inviate/cod/" . $codiceNotifica;
        elseif (!is_null($id)) $url = $this->baseUrl . "/notifiche-inviate/id/" . $id;
        elseif (!is_null($codiceOperatore)) $url = $this->baseUrl . "/notifiche-inviate/op/" . $codiceOperatore;
        else $url = $this->baseUrl . "/notifiche-inviate";
        return call_user_func([$this->httpClass, "get"], $url, ["Authorization: " . $this->authToken]);
    }

    public function getOrari($id = NULL, $tipologia = NULL, $codiceOrario = NULL)
    {
        if (!is_null($id)) $url = $this->baseUrl . "/orari/id/" . $id;
        elseif (!is_null($tipologia)) $url = $this->baseUrl . "/orari/tipologia/" . $tipologia;
        elseif (!is_null($codiceOrario)) $url = $this->baseUrl . "/orari/cod/" . $codiceOrario;
        else $url = $this->baseUrl . "/orari";
        return call_user_func([$this->httpClass, "get"], $url, ["Authorization: " . $this->authToken]);
    }

    public function getSkill($codice = NULL)
    {
        if (!is_null($codice)) $url = $this->baseUrl . "/skill/cod/" . $codice;
        else $url = $this->baseUrl . "/skill";
        return call_user_func([$this->httpClass, "get"], $url, ["Authorization: " . $this->authToken]);
    }

    public function getSkillOperatori($codSkill = NULL, $codiceOperatore = NULL)
    {
        if (!is_null($codSkill)) $url = $this->baseUrl . "/skill-operatori/cod/" . $codSkill;
        elseif (!is_null($codiceOperatore)) $url = $this->baseUrl . "/skill-operatori/op/" . $codiceOperatore;
        else $url = $this->baseUrl . "/skill-operatori";
        return call_user_func([$this->httpClass, "get"], $url, ["Authorization: " . $this->authToken]);
    }

    public function getOrdiniDiLavoroLink($cod1 = NULL, $cod2 = NULL)
    {
        if (!is_null($cod1) && !is_null($cod2)) $url = $this->baseUrl . "/ordini-di-lavoro-link/cod1/" . $cod1 . "/cod2/" . $cod2;
        elseif (!is_null($cod1)) $url = $this->baseUrl . "/ordini-di-lavoro-link/cod1/" . $cod1;
        elseif (!is_null($cod2)) $url = $this->baseUrl . "/ordini-di-lavoro-link/cod1/" . $cod2;
        else $url = $this->baseUrl . "/ordini-di-lavoro-link";
        return call_user_func([$this->httpClass, "get"], $url, ["Authorization: " . $this->authToken]);
    }

    public function getTurni($id = NULL, $codice = NULL, $codiceOrario = NULL)
    {
        if (!is_null($codice)) $url = $this->baseUrl . "/turni/codice/" . $codice;
        elseif (!is_null($id)) $url = $this->baseUrl . "/turni/id/" . $id;
        elseif (!is_null($id)) $url = $this->baseUrl . "/turni/codice-orario/" . $codiceOrario;
        else $url = $this->baseUrl . "/turni";
        return call_user_func([$this->httpClass, "get"], $url, ["Authorization: " . $this->authToken]);
    }

    public function getSquadre($id = NULL, $codice = NULL, $codiceOperatore = NULL)
    {
        if (!is_null($codice)) $url = $this->baseUrl . "/squadre/codice/" . $codice;
        elseif (!is_null($id)) $url = $this->baseUrl . "/squadre/id/" . $id;
        elseif (!is_null($id)) $url = $this->baseUrl . "/squadre/operatore/" . $codiceOperatore;
        else $url = $this->baseUrl . "/squadre";
        return call_user_func([$this->httpClass, "get"], $url, ["Authorization: " . $this->authToken]);
    }

    public function getProtocolliMisurazioni($id = NULL, $protocollo = NULL, $item = NULL, $endPoint = NULL)
    {
        if (!is_null($id)) $url = $this->baseUrl . "/protocolli-misurazioni/id/" . $id;
        elseif (!is_null($protocollo) && !is_null($item) && !is_null($endPoint)) $url = $this->baseUrl . "/protocolli-misurazioni/endpoint/" . $endPoint . "/protocollo/" . $protocollo . "/item/" . $item;
        elseif (!is_null($protocollo) && !is_null($item)) $url = $this->baseUrl . "/protocolli-misurazioni/protocollo/" . $protocollo . "/item/" . $item;
        elseif (!is_null($protocollo)) $url = $this->baseUrl . "/protocolli-misurazioni/protocollo/" . $protocollo;
        elseif (!is_null($item)) $url = $this->baseUrl . "/protocolli-misurazioni/item/" . $item;
        else $url = $this->baseUrl . "/protocolli-misurazioni";
        return call_user_func([$this->httpClass, "get"], $url, ["Authorization: " . $this->authToken]);
    }

    public function getCentriDiLavoroProtocolliMisurazioni($id = NULL, $codiceCdl = NULL, $protocollo = NULL, $item = NULL, $protocolloId = NULL, $endPoint = NULL)
    {
        if (!is_null($id)) $url = $this->baseUrl . "/centri-di-lavoro-protocolli-misurazioni/id/" . $id;
        elseif (!is_null($protocollo) && !is_null($item) && !is_null($codiceCdl)) $url = $this->baseUrl . "/centri-di-lavoro-protocolli-misurazioni/cdl/" . $codiceCdl . "/protocollo/" . $protocollo . "/item/" . $item;
        elseif (!is_null($protocollo) && !is_null($item) && !is_null($endPoint)) $url = $this->baseUrl . "/centri-di-lavoro-protocolli-misurazioni/endpoint/" . $endPoint . "/protocollo/" . $protocollo . "/item/" . $item;
        elseif (!is_null($codiceCdl) && !is_null($protocollo)) $url = $this->baseUrl . "/centri-di-lavoro-protocolli-misurazioni/cdl/" . $codiceCdl . "/protocollo/" . $protocollo;
        elseif (!is_null($codiceCdl) && !is_null($protocolloId)) $url = $this->baseUrl . "/centri-di-lavoro-protocolli-misurazioni/cdl/" . $codiceCdl . "/protocollo-id/" . $protocolloId;
        elseif (!is_null($protocollo)) $url = $this->baseUrl . "/centri-di-lavoro-protocolli-misurazioni/protocollo/" . $protocollo;
        elseif (!is_null($codiceCdl)) $url = $this->baseUrl . "/centri-di-lavoro-protocolli-misurazioni/cdl/" . $codiceCdl;
        elseif (!is_null($item)) $url = $this->baseUrl . "/centri-di-lavoro-protocolli-misurazioni/item/" . $item;
        elseif (!is_null($protocolloId)) $url = $this->baseUrl . "/centri-di-lavoro-protocolli-misurazioni/protocollo-id/" . $protocolloId;
        else $url = $this->baseUrl . "/centri-di-lavoro-protocolli-misurazioni";
        return call_user_func([$this->httpClass, "get"], $url, ["Authorization: " . $this->authToken]);
    }

    public function getMisurazioniUnita($id = NULL, $type = NULL, $name = NULL, $code = NULL)
    {
        if (!is_null($id)) $url = $this->baseUrl . "/misurazioni-unita/id/" . $id;
        elseif (!is_null($type) && !is_null($name)) $url = $this->baseUrl . "/misurazioni-unita/type/" . $type . "/name/" . $name;
        elseif (!is_null($type)) $url = $this->baseUrl . "/misurazioni-unita/type/" . $type;
        elseif (!is_null($name)) $url = $this->baseUrl . "/misurazioni-unita/name/" . $name;
        elseif (!is_null($code)) $url = $this->baseUrl . "/misurazioni-unita/code/" . $code;
        else $url = $this->baseUrl . "/misurazioni-unita";
        return call_user_func([$this->httpClass, "get"], $url, ["Authorization: " . $this->authToken]);
    }

    public function getStoricoMisurazioni($id = NULL, $startDate = NULL, $protocollo = NULL, $item = NULL, $ultimo = NULL, $endPoint = NULL, $endDate = NULL, $filter = false, $limit = 100)
    {
        $url = $this->baseUrl . "/storico-misurazioni";
        if ($filter) {
            $url .= "/filter?";
            $filter = [];
            if (!is_null($id)) $filter[] = "id=" . $id;
            if (!is_null($protocollo)) $filter[] = "protocol=" . $protocollo;
            if (!is_null($item)) $filter[] = "item=" . $item;
            if (!is_null($endPoint)) $filter[] = "endpoint=" . $endPoint;
            if (!is_null($startDate)) $filter[] = "startdate=" . $startDate;
            if (!is_null($endDate)) $filter[] = "enddate=" . $endDate;
            if (!is_null($limit)) $filter[] = "limit=" . $limit;
            $url .= implode("&", $filter);
        } else {
            if (!is_null($id)) $url .= "/id/" . $id;
            if (!is_null($ultimo)) $url .= "/ultimo";
            if (!is_null($protocollo)) $url .= "/protocollo/" . $protocollo;
            if (!is_null($item)) $url .= "/item/" . $item;
            if (!is_null($endPoint)) $url .= "/endpoint/" . $endPoint;
            if (!is_null($startDate)) $url .= "/startdate/" . $startDate;
            if (!is_null($endDate)) $url .= "/enddate/" . $endDate;
        }
        return call_user_func([$this->httpClass, "get"], $url, ["Authorization: " . $this->authToken]);
    }

    public function getLottiSeriali($id = NULL, $codiceOdl = NULL, $codiceFase = NULL)
    {
        if (!is_null($id)) $url = $this->baseUrl . "/lotti-seriali/id/" . $id;
        elseif (!is_null($codiceOdl) && !is_null($codiceFase)) $url = $this->baseUrl . "/lotti-seriali/odl/" . $codiceOdl . "/fase/" . $codiceFase;
        elseif (!is_null($codiceOdl)) $url = $this->baseUrl . "/lotti-seriali/odl/" . $codiceOdl;
        elseif (!is_null($codiceFase)) $url = $this->baseUrl . "/lotti-seriali/fase/" . $codiceFase;
        else $url = $this->baseUrl . "/lotti-seriali";
        return call_user_func([$this->httpClass, "get"], $url, ["Authorization: " . $this->authToken]);
    }

    public function getStoricoMisurazioniBuffer($id = NULL, $startDate = NULL, $protocollo = NULL, $item = NULL, $ultimo = NULL, $endPoint = NULL)
    {
        if (!is_null($id)) $url = $this->baseUrl . "/storico-misurazioni-buffer/id/" . $id;
        elseif (!is_null($ultimo) && !is_null($item) && !is_null($protocollo) && !is_null($endPoint)) $url = $this->baseUrl . "/storico-misurazioni-buffer/ultimo/protocollo/" . $protocollo . "/item/" . $item . "/endpoint/" . $endPoint;
        elseif (!is_null($ultimo) && !is_null($item) && !is_null($protocollo)) $url = $this->baseUrl . "/storico-misurazioni-buffer/ultimo/protocollo/" . $protocollo . "/item/" . $item;
        elseif (!is_null($startDate)) $url = $this->baseUrl . "/storico-misurazioni-buffer/startdate/" . $startDate;
        elseif (!is_null($ultimo)) $url = $this->baseUrl . "/storico-misurazioni-buffer/ultimo";
        else $url = $this->baseUrl . "/storico-misurazioni-buffer";
        return call_user_func([$this->httpClass, "get"], $url, ["Authorization: " . $this->authToken]);
    }

    public function getChat($id = NULL, $ip = NULL, $mittente = NULL, $codiceOperatore = NULL)
    {
        if (!is_null($id)) $url = $this->baseUrl . "/chat/id/" . $id;
        elseif (!is_null($ip)) $url = $this->baseUrl . "/chat/ip/" . $ip;
        elseif (!is_null($mittente)) $url = $this->baseUrl . "/chat/mittente/" . $mittente;
        elseif (!is_null($codiceOperatore)) $url = $this->baseUrl . "/chat/operatore/" . $codiceOperatore;
        else $url = $this->baseUrl . "/chat";
        return call_user_func([$this->httpClass, "get"], $url, ["Authorization: " . $this->authToken]);
    }

    public function getArtefatti($id = NULL, $runningTaskId = NULL, $taskId = NULL, $codiceOdl = NULL, $codiceFase = NULL, $codiceCdl = NULL, $codiceOperatore = NULL, $lotto = NULL, $seriale = NULL)
    {
        if (!is_null($id)) $url = $this->baseUrl . "/artefatti/id/" . $id;
        elseif (!is_null($runningTaskId)) $url = $this->baseUrl . "/artefatti/running-task/" . $runningTaskId;
        elseif (!is_null($taskId)) $url = $this->baseUrl . "/artefatti/task/" . $taskId;
        elseif (!is_null($codiceOdl) && !is_null($codiceFase)) $url = $this->baseUrl . "/artefatti/odl/" . $codiceOdl . "/fase/" . $codiceFase;
        elseif (!is_null($codiceOdl) && !is_null($codiceCdl)) $url = $this->baseUrl . "/artefatti/odl/" . $codiceOdl . "/cdl/" . $codiceCdl;
        elseif (!is_null($codiceOdl)) $url = $this->baseUrl . "/artefatti/odl/" . $codiceOdl;
        elseif (!is_null($codiceFase)) $url = $this->baseUrl . "/artefatti/fase/" . $codiceFase;
        elseif (!is_null($codiceCdl)) $url = $this->baseUrl . "/artefatti/cdl/" . $codiceCdl;
        elseif (!is_null($codiceOperatore)) $url = $this->baseUrl . "/artefatti/op/" . $codiceOperatore;
        elseif (!is_null($lotto)) $url = $this->baseUrl . "/artefatti/lotto/" . $lotto;
        elseif (!is_null($seriale)) $url = $this->baseUrl . "/artefatti/seriale/" . $seriale;
        else $url = $this->baseUrl . "/artefatti";
        return call_user_func([$this->httpClass, "get"], $url, ["Authorization: " . $this->authToken]);
    }

    public function getEtichetteStampate($id = NULL, $runningTaskId = NULL, $codiceCdl = NULL)
    {
        if (!is_null($id)) $url = $this->baseUrl . "/etichette-stampate/id/" . $id;
        elseif (!is_null($runningTaskId)) $url = $this->baseUrl . "/etichette-stampate/running-task/" . $runningTaskId;
        elseif (!is_null($codiceCdl)) $url = $this->baseUrl . "/etichette-stampate/cdl/" . $codiceCdl;
        else $url = $this->baseUrl . "/etichette-stampate";
        return call_user_func([$this->httpClass, "get"], $url, ["Authorization: " . $this->authToken]);
    }

    public function getTaskNoteErp($codiceOdl = NULL, $codiceFase = NULL, $codiceArticolo = NULL, $codiceFaseExtra = NULL)
    {
        if (!is_null($codiceOdl) && !is_null($codiceFase)) $url = $this->baseUrl . "/task-note-erp/odl/" . urlencode($codiceOdl) . "/fase/" . urlencode($codiceFase);
        elseif (!is_null($codiceArticolo) && !is_null($codiceFaseExtra)) $url = $this->baseUrl . "/task-note-erp/articolo/" . urlencode($codiceArticolo) . "/fase-extra/" . $codiceFaseExtra;
        elseif (!is_null($codiceOdl)) $url = $this->baseUrl . "/task-note-erp/odl/" . urlencode($codiceOdl);
        elseif (!is_null($codiceFase)) $url = $this->baseUrl . "/task-note-erp/fase/" . urlencode($codiceFase);
        else $url = $this->baseUrl . "/task-note-erp";
        return call_user_func([$this->httpClass, "get"], $url, ["Authorization: " . $this->authToken]);
    }

    public function getNesting($id = NULL, $codiceNesting = NULL)
    {
        if (!is_null($id)) $url = $this->baseUrl . "/nesting/" . $id;
        elseif (!is_null($codiceNesting)) $url = $this->baseUrl . "/nesting/codice/" . $codiceNesting;
        else $url = $this->baseUrl . "/nesting";
        return call_user_func([$this->httpClass, "get"], $url, ["Authorization: " . $this->authToken]);
    }

    public function getMateriali($id = NULL, $codm = NULL)
    {
        if (!is_null($id)) $url = $this->baseUrl . "/materiali/id/" . $id;
        elseif (!is_null($codm)) $url = $this->baseUrl . "/materiali/codice/" . urlencode($codm);
        else $url = $this->baseUrl . "/materiali";
        return call_user_func([$this->httpClass, "get"], $url, ["Authorization: " . $this->authToken]);
    }

    public function getFormQualita($id = NULL, $codiceArticolo = NULL)
    {
        if (!is_null($id)) $url = $this->baseUrl . "/form-qualita/id/" . $id;
        elseif (!is_null($codiceArticolo)) $url = $this->baseUrl . "/form-qualita/articolo/" . urlencode($codiceArticolo);
        else $url = $this->baseUrl . "/form-qualita";
        return call_user_func([$this->httpClass, "get"], $url, ["Authorization: " . $this->authToken]);
    }

    public function getFormQualitaCompilati($id = NULL, $idDocumento = NULL, $idRiga = NULL, $codiceCdl = NULL, $taskId = NULL, $runningTaskId = NULL, $idFormQualita = NULL)
    {
        if (!is_null($id)) $url = $this->baseUrl . "/form-qualita-compilati/id/" . $id;
        elseif (!is_null($idDocumento) && !is_null($idRiga)) $url = $this->baseUrl . "/form-qualita-compilati/documento/" . $idDocumento . "/riga/" . $idRiga;
        elseif (!is_null($idDocumento)) $url = $this->baseUrl . "/form-qualita-compilati/documento/" . $idDocumento;
        elseif (!is_null($codiceCdl)) $url = $this->baseUrl . "/form-qualita-compilati/cdl/" . $codiceCdl;
        elseif (!is_null($taskId)) $url = $this->baseUrl . "/form-qualita-compilati/task/" . $taskId;
        elseif (!is_null($runningTaskId)) $url = $this->baseUrl . "/form-qualita-compilati/running-task/" . $runningTaskId;
        elseif (!is_null($idFormQualita)) $url = $this->baseUrl . "/form-qualita-compilati/form-qualita/" . $idFormQualita;
        else $url = $this->baseUrl . "/form-qualita-compilati";
        return call_user_func([$this->httpClass, "get"], $url, ["Authorization: " . $this->authToken]);
    }

    public function getDraftTask($id = NULL, $cdl = NULL)
    {
        if (!is_null($id)) $url = $this->baseUrl . "/draft-task/id/" . $id;
        elseif (!is_null($cdl)) $url = $this->baseUrl . "/draft-task/cdl/" . $cdl;
        else $url = $this->baseUrl . "/draft-task";
        return call_user_func([$this->httpClass, "get"], $url, ["Authorization: " . $this->authToken]);
    }

    public function getCausaliProduzione($cod = NULL)
    {
        if (!is_null($cod)) $url = $this->baseUrl . "/causali-produzione/cod/" . $cod;
        else $url = $this->baseUrl . "/causali-produzione";
        return call_user_func([$this->httpClass, "get"], $url, ["Authorization: " . $this->authToken]);
    }

    public function getStabilimenti($cod = NULL)
    {
        if (!is_null($cod)) $url = $this->baseUrl . "/stabilimenti/cod/" . $cod;
        else $url = $this->baseUrl . "/stabilimenti";
        return call_user_func([$this->httpClass, "get"], $url, ["Authorization: " . $this->authToken]);
    }

    public function getImpianti($codiceImpianto = NULL, $codiceReparto = NULL)
    {
        if (!is_null($codiceImpianto)) $url = $this->baseUrl . "/impianti/cod/" . $codiceImpianto;
        elseif (!is_null($codiceReparto)) $url = $this->baseUrl . "/impianti/reparto/" . $codiceReparto;
        else $url = $this->baseUrl . "/impianti";
        return call_user_func([$this->httpClass, "get"], $url, ["Authorization: " . $this->authToken]);
    }

    public function getNodi($codiceNodo = NULL, $codidceImpianto = NULL)
    {
        if (!is_null($codiceNodo)) $url = $this->baseUrl . "/nodi/nodo/" . $codiceNodo;
        elseif (!is_null($codidceImpianto)) $url = $this->baseUrl . "/nodi/impianto/" . $codidceImpianto;
        else $url = $this->baseUrl . "/nodi";
        return call_user_func([$this->httpClass, "get"], $url, ["Authorization: " . $this->authToken]);
    }

    public function getNodiCentriDiLavoro($codiceNodo = NULL)
    {
        if (!is_null($codiceNodo)) $url = $this->baseUrl . "/nodi-centri-di-lavoro/nodo/" . $codiceNodo;
        else $url = $this->baseUrl . "/nodi-centri-di-lavoro";
        return call_user_func([$this->httpClass, "get"], $url, ["Authorization: " . $this->authToken]);
    }

    public function getStoricoEventiCdl($codiceCdl)
    {
        $url = $this->baseUrl . "/storico-eventi-cdl/cdl/" . $codiceCdl;
        return call_user_func([$this->httpClass, "get"], $url, ["Authorization: " . $this->authToken]);
    }

    public function getCentriDiLavoroTransazioniLavorazione($id = NULL, $codiceCdl = NULL, $completato = NULL)
    {
        if (!is_null($id)) $url = $this->baseUrl . "/centri-di-lavoro-transazioni-lavorazione/id/" . $id;
        elseif (!is_null($codiceCdl) && !is_null($completato)) $url = $this->baseUrl . "/centri-di-lavoro-transazioni-lavorazione/cdl/" . $codiceCdl . "/completate/" . $completato;
        elseif (!is_null($codiceCdl)) $url = $this->baseUrl . "/centri-di-lavoro-transazioni-lavorazione/cdl/" . $codiceCdl;
        elseif (!is_null($completato)) $url = $this->baseUrl . "/centri-di-lavoro-transazioni-lavorazione/completate/" . $completato;
        else $url = $this->baseUrl . "/centri-di-lavoro-transazioni-lavorazione";
        return call_user_func([$this->httpClass, "get"], $url, ["Authorization: " . $this->authToken]);
    }

    public function getCentriDiLavoroRegoleMisurazioniConsumi($id = NULL, $codiceCdl = NULL, $uuid = NULL)
    {
        if (!is_null($codiceCdl)) $url = $this->baseUrl . "/centri-di-lavoro-regole-misurazioni-consumi/cdl/" . $codiceCdl;
        elseif (!is_null($uuid)) $url = $this->baseUrl . "/centri-di-lavoro-regole-misurazioni-consumi/uuid/" . $uuid;
        else $url = $this->baseUrl . "/centri-di-lavoro-regole-misurazioni-consumi";
        return call_user_func([$this->httpClass, "get"], $url, ["Authorization: " . $this->authToken]);
    }

    public function getReport($id = NULL, $taskId = NULL, $codiceOdl = NULL)
    {
        if (!is_null($id)) $url = $this->baseUrl . "/report/id/" . $id;
        elseif (!is_null($taskId)) $url = $this->baseUrl . "/report/task/" . $taskId;
        elseif (!is_null($codiceOdl)) $url = $this->baseUrl . "/report/odl/" . $codiceOdl;
        else $url = $this->baseUrl . "/report";
        return call_user_func([$this->httpClass, "get"], $url, ["Authorization: " . $this->authToken]);
    }










    public function putRunningTask($data)
    {
        $url = $this->baseUrl . "/running-task";
        return call_user_func([$this->httpClass, "put"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function putTaskScarti($data)
    {
        $url = $this->baseUrl . "/task-scarti";
        return call_user_func([$this->httpClass, "put"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function putCentriDiLavoroIp($data)
    {
        $url = $this->baseUrl . "/centri-di-lavoro-ip";
        return call_user_func([$this->httpClass, "put"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function putDistintaBase($data)
    {
        $url = $this->baseUrl . "/distinta-base";
        return call_user_func([$this->httpClass, "put"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function putLotti($data)
    {
        $url = $this->baseUrl . "/lotti";
        return call_user_func([$this->httpClass, "put"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function putDistintaBaseUsata($data)
    {
        $url = $this->baseUrl . "/distinta-base-usata";
        return call_user_func([$this->httpClass, "put"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function putDistintaBaseUsataScarico($data)
    {
        $url = $this->baseUrl . "/distinta-base-usata-scarico";
        return call_user_func([$this->httpClass, "put"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function putReparto($data)
    {
        $url = $this->baseUrl . "/reparti";
        return call_user_func([$this->httpClass, "put"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function putCentroDiLavoroStato($data)
    {
        $url = $this->baseUrl . "/centri-di-lavoro-stato";
        return call_user_func([$this->httpClass, "put"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function putLottiAttrezzature($data)
    {
        $url = $this->baseUrl . "/attrezzature-lotti";
        return call_user_func([$this->httpClass, "put"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function putAttrezzaturaUsata($data)
    {
        $url = $this->baseUrl . "/attrezzature-usate";
        return call_user_func([$this->httpClass, "put"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function putAttrezzaturaUsataValutazione($data)
    {
        $url = $this->baseUrl . "/attrezzature-usate-valutazione";
        return call_user_func([$this->httpClass, "put"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function putCentroDiLavoroManutenzione($data)
    {
        $url = $this->baseUrl . "/centri-di-lavoro-manutenzione";
        return call_user_func([$this->httpClass, "put"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function putAttivitaExtra($data)
    {
        $url = $this->baseUrl . "/attivita-extra";
        return call_user_func([$this->httpClass, "put"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function putAttivitaTask($data)
    {
        $url = $this->baseUrl . "/attivita-task";
        return call_user_func([$this->httpClass, "put"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function putIfttt($data)
    {
        $url = $this->baseUrl . "/ifttt";
        return call_user_func([$this->httpClass, "put"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function putSfrido($data)
    {
        $url = $this->baseUrl . "/sfrido";
        return call_user_func([$this->httpClass, "put"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function putCentriDiLavoroProcessi($data)
    {
        $url = $this->baseUrl . "/centri-di-lavoro-processi";
        return call_user_func([$this->httpClass, "put"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function putCentriDiLavoroGruppi($data)
    {
        $url = $this->baseUrl . "/centri-di-lavoro-gruppi";
        return call_user_func([$this->httpClass, "put"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function putRuolo($data)
    {
        $url = $this->baseUrl . "/ruoli";
        return call_user_func([$this->httpClass, "put"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function putNotifica($data)
    {
        $url = $this->baseUrl . "/notifiche";
        return call_user_func([$this->httpClass, "put"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function putOperatore($data)
    {
        $url = $this->baseUrl . "/operatori";
        return call_user_func([$this->httpClass, "put"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function putSkill($data)
    {
        $url = $this->baseUrl . "/skill";
        return call_user_func([$this->httpClass, "put"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function putRunningTaskStatus($data)
    {
        $url = $this->baseUrl . "/running-task-status";
        return call_user_func([$this->httpClass, "put"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function putRunningTaskQnt($data)
    {
        $url = $this->baseUrl . "/running-task-quantity";
        return call_user_func([$this->httpClass, "put"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function putTaskQnt($data)
    {
        $url = $this->baseUrl . "/task-quantity";
        return call_user_func([$this->httpClass, "put"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function putRunningTaskCausaliSospensione($data)
    {
        $url = $this->baseUrl . "/running-task-causali-sospensione";
        return call_user_func([$this->httpClass, "put"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function putUpdateCausaliSospensione($data)
    {
        $url = $this->baseUrl . "/causali-sospensione-update-gruppo";
        return call_user_func([$this->httpClass, "put"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function putUpdateCausaliScarto($data)
    {
        $url = $this->baseUrl . "/causali-scarto-update-gruppo";
        return call_user_func([$this->httpClass, "put"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function putGruppoSospensione($data)
    {
        $url = $this->baseUrl . "/causali-sospensione-gruppi";
        return call_user_func([$this->httpClass, "put"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function putGruppoScarto($data)
    {
        $url = $this->baseUrl . "/causali-scarto-gruppi";
        return call_user_func([$this->httpClass, "put"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function putTaskEliminato($data)
    {
        $url = $this->baseUrl . "/task-eliminati";
        return call_user_func([$this->httpClass, "put"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function putRunningTaskImpronte($data)
    {
        $url = $this->baseUrl . "/running-task-impronte";
        return call_user_func([$this->httpClass, "put"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function putRunningTaskContapezziIniziale($data)
    {
        $url = $this->baseUrl . "/running-task-contapezzi-iniziale";
        return call_user_func([$this->httpClass, "put"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function putWebhook($data)
    {
        $url = $this->baseUrl . "/webhook";
        return call_user_func([$this->httpClass, "put"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function putCentroDiLavoroStatoProd($data)
    {
        $url = $this->baseUrl . "/centri-di-lavoro-stato-produzione";
        return call_user_func([$this->httpClass, "put"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function putCentroDiLavoroAbilitato($data)
    {
        $url = $this->baseUrl . "/centri-di-lavoro-abilitati";
        return call_user_func([$this->httpClass, "put"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function putCentroDiLavoroMisurazione($data)
    {
        $url = $this->baseUrl . "/centri-di-lavoro-misurazioni";
        return call_user_func([$this->httpClass, "put"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function putCentriDiLavoroGruppo($data)
    {
        $url = $this->baseUrl . "/centri-di-lavoro-gruppi";
        return call_user_func([$this->httpClass, "put"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function putCentriDiLavoroGruppoCodice($data)
    {
        $url = $this->baseUrl . "/centri-di-lavoro-gruppi-codice";
        return call_user_func([$this->httpClass, "put"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function putNotificaInviata($data)
    {
        $url = $this->baseUrl . "/notifiche-inviate";
        return call_user_func([$this->httpClass, "put"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function putOrario($data)
    {
        $url = $this->baseUrl . "/orari";
        return call_user_func([$this->httpClass, "put"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function putOperatoreOrario($data)
    {
        $url = $this->baseUrl . "/operatori-orari";
        return call_user_func([$this->httpClass, "put"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function putCentroDiLavoroOrario($data)
    {
        $url = $this->baseUrl . "/centri-di-lavoro-orari";
        return call_user_func([$this->httpClass, "put"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function putOperatoreCosto($data)
    {
        $url = $this->baseUrl . "/operatori-costo";
        return call_user_func([$this->httpClass, "put"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function putCentroDiLavoroCosto($data)
    {
        $url = $this->baseUrl . "/centri-di-lavoro-costo";
        return call_user_func([$this->httpClass, "put"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function putTaskOperatoriAssegnati($data)
    {
        $url = $this->baseUrl . "/task-operatori-assegnati";
        return call_user_func([$this->httpClass, "put"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function putCentroDiLavoroSquadra($data)
    {
        $url = $this->baseUrl . "/centri-di-lavoro-squadra";
        return call_user_func([$this->httpClass, "put"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function putSquadreOperatori($data)
    {
        $url = $this->baseUrl . "/squadre-operatori";
        return call_user_func([$this->httpClass, "put"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function putEventoData($data)
    {
        $url = $this->baseUrl . "/eventi-data";
        return call_user_func([$this->httpClass, "put"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function putProtocolliMisurazioni($data)
    {
        $url = $this->baseUrl . "/protocolli-misurazioni";
        return call_user_func([$this->httpClass, "put"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function putCentriDiLavoroProtocolliMisurazioni($data)
    {
        $url = $this->baseUrl . "/centri-di-lavoro-protocolli-misurazioni";
        return call_user_func([$this->httpClass, "put"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function putChatLettura($id)
    {
        $url = $this->baseUrl . "/chat-lettura";
        $data = ["id" => $id];
        return call_user_func([$this->httpClass, "put"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    /**
     * @param string $statoMarcatempo "dentro" o "fuori"
     */
    public function putOperatoreStatoMarcatempo($codiceOperatore, $statoMarcatempo)
    {
        $url = $this->baseUrl . "/operatore-stato-marcatempo";
        $data = ["CodiceOperatore" => $codiceOperatore, "StatoMarcatempo" => $statoMarcatempo];
        return call_user_func([$this->httpClass, "put"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function putCentroDiLavoroContapezziAutomatico($data)
    {
        $url = $this->baseUrl . "/centri-di-lavoro-contapezzi-automatico";
        return call_user_func([$this->httpClass, "put"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function putEtichetteStampatePassatoErp($data)
    {
        $url = $this->baseUrl . "/etichette-stampate-passato-erp";
        return call_user_func([$this->httpClass, "put"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function putEtichetteStampateLettoErp($data)
    {
        $url = $this->baseUrl . "/etichette-stampate-letto-erp";
        return call_user_func([$this->httpClass, "put"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function putCompletaTask($data)
    {
        $url = $this->baseUrl . "/task-completato";
        return call_user_func([$this->httpClass, "put"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function putTaskNoteErpLetto($id, $letto)
    {
        $data = ["Id" => $id, "Letto" => $letto];
        $url = $this->baseUrl . "/task-note-erp-letto";
        return call_user_func([$this->httpClass, "put"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function putTaskNoteErpOperatoriLettura($id, $operatori)
    {
        $data = ["Id" => $id, "OperatoriLettura" => $operatori];
        $url = $this->baseUrl . "/task-note-erp-operatori-lettura";
        return call_user_func([$this->httpClass, "put"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function putCentroDiLavoroDistintaBaseScarico($data)
    {
        $url = $this->baseUrl . "/centri-di-lavoro-distinta-base-scarico";
        return call_user_func([$this->httpClass, "put"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function putLottiGiacenza($data)
    {
        $url = $this->baseUrl . "/lotti-giacenza";
        return call_user_func([$this->httpClass, "put"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function putMaterialiGiacenza($data)
    {
        $url = $this->baseUrl . "/materiali-giacenza";
        return call_user_func([$this->httpClass, "put"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function putCentroDiLavoroTipoReport($data)
    {
        $url = $this->baseUrl . "/centri-di-lavoro-tipo-report";
        return call_user_func([$this->httpClass, "put"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function putOrdiniDiLavoro($data)
    {
        $url = $this->baseUrl . "/ordini-di-lavoro";
        return call_user_func([$this->httpClass, "put"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function putFasi($data)
    {
        $url = $this->baseUrl . "/fasi";
        return call_user_func([$this->httpClass, "put"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function putFormQualita($data)
    {
        $url = $this->baseUrl . "/form-qualita";
        return call_user_func([$this->httpClass, "put"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function putFormQualitaCompilati($data)
    {
        $url = $this->baseUrl . "/form-qualita-compilati";
        return call_user_func([$this->httpClass, "put"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function putDistintaBaseUsataQnt($data)
    {
        $url = $this->baseUrl . "/distinta-base-usata-qnt";
        return call_user_func([$this->httpClass, "put"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function putTaskDraft($data)
    {
        $url = $this->baseUrl . "/task-draft";
        return call_user_func([$this->httpClass, "put"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function putCausaliProduzione($data)
    {
        $url = $this->baseUrl . "/causali-produzione";
        return call_user_func([$this->httpClass, "put"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function putEtichetteStampateQuantitaDichiarata($data)
    {
        $url = $this->baseUrl . "/etichette-stampate-quantita-dichiarata";
        return call_user_func([$this->httpClass, "put"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function putEtichetteStampateQuantitaScartata($data)
    {
        $url = $this->baseUrl . "/etichette-stampate-quantita-scartata";
        return call_user_func([$this->httpClass, "put"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function putImpianti($data)
    {
        $url = $this->baseUrl . "/impianti";
        return call_user_func([$this->httpClass, "put"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function putStabilimenti($data)
    {
        $url = $this->baseUrl . "/stabilimenti";
        return call_user_func([$this->httpClass, "put"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function putNodi($data)
    {
        $url = $this->baseUrl . "/nodi";
        return call_user_func([$this->httpClass, "put"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function putCentroDiLavoroConsumi($data)
    {
        $url = $this->baseUrl . "/centri-di-lavoro-consumi";
        return call_user_func([$this->httpClass, "put"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function putDistintaBaseUsataStorno($data)
    {
        $url = $this->baseUrl . "/distinta-base-usata-storno";
        return call_user_func([$this->httpClass, "put"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function putCentriDiLavoroCalcoloDistintaBase($data)
    {
        $url = $this->baseUrl . "/centri-di-lavoro-calcolo-distinta-base";
        return call_user_func([$this->httpClass, "put"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function putCentriDiLavoroTransazioniLavorazione($data)
    {
        $url = $this->baseUrl . "/centri-di-lavoro-transazioni-lavorazione";
        return call_user_func([$this->httpClass, "put"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function putCentriDiLavoroTipoChiusuraTransazione($data)
    {
        $url = $this->baseUrl . "/centri-di-lavoro-chiusura-transazione";
        return call_user_func([$this->httpClass, "put"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function putCentroDiLavoroLavorazioneNesting($data) {
        $url = $this->baseUrl."/centri-di-lavoro-lavorazione-nesting";
        return call_user_func([$this->httpClass,"put"],$url,$data,"application/json",["Authorization: ".$this->authToken]);
    }

    public function putCentriDiLavoroRegoleMisurazioniConsumi($data) {
        $url = $this->baseUrl."/centri-di-lavoro-regole-misurazioni-consumi";
        return call_user_func([$this->httpClass,"put"],$url,$data,"application/json",["Authorization: ".$this->authToken]);
    }

    public function putProtocolliMisurazioniMisuraRiferimento($data) {
        $url = $this->baseUrl."/protocolli-misurazioni-misura-riferimento";
        return call_user_func([$this->httpClass,"put"],$url,$data,"application/json",["Authorization: ".$this->authToken]);
    }

    public function putCausaliSospensione($data)
    {
        $url = $this->baseUrl . "/causali-sospensione";
        return call_user_func([$this->httpClass, "put"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function putCausaliScarto($data)
    {
        $url = $this->baseUrl . "/causali-scarto";
        return call_user_func([$this->httpClass, "put"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }











    public function postSKillOperatori($data)
    {
        $url = $this->baseUrl . "/skill-operatori";
        return call_user_func([$this->httpClass, "post"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function postCdlOperatori($data)
    {
        $url = $this->baseUrl . "/centri-di-lavoro-operatori";
        return call_user_func([$this->httpClass, "post"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function postRuoloOperatori($data)
    {
        $url = $this->baseUrl . "/ruoli-operatori";
        return call_user_func([$this->httpClass, "post"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function postCentroDiLavoroManutenzioneStorico($data)
    {
        $url = $this->baseUrl . "/centri-di-lavoro-manutenzione-storico";
        return call_user_func([$this->httpClass, "post"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function postRepartoCentriDiLavoro($data)
    {
        $url = $this->baseUrl . "/reparti-centri-di-lavoro";
        return call_user_func([$this->httpClass, "post"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function postRepartoOperatori($data)
    {
        $url = $this->baseUrl . "/reparti-operatori";
        return call_user_func([$this->httpClass, "post"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function postGruppoCausaliSospensione($data)
    {
        $url = $this->baseUrl . "/causali-sospensione-gruppi";
        return call_user_func([$this->httpClass, "post"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function postGruppoCausaliScarto($data)
    {
        $url = $this->baseUrl . "/causali-scarto-gruppi";
        return call_user_func([$this->httpClass, "post"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function postEtichetta($data)
    {
        $url = $this->baseUrl . "/etichette";
        return call_user_func([$this->httpClass, "post"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function postProduzioneLotto($data)
    {
        $url = $this->baseUrl . "/lotti-produzione";
        return call_user_func([$this->httpClass, "post"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function postEventLog($data)
    {
        $url = $this->baseUrl . "/eventi";
        return call_user_func([$this->httpClass, "post"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function postTask($data)
    {
        $url = $this->baseUrl . "/task";
        return call_user_func([$this->httpClass, "post"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function postWebhook($data)
    {
        $url = $this->baseUrl . "/webhook";
        return call_user_func([$this->httpClass, "post"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function postWebhookHistory($data)
    {
        $url = $this->baseUrl . "/webhook-history";
        return call_user_func([$this->httpClass, "post"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function postCentroDiLavoroStat($data)
    {
        $url = $this->baseUrl . "/centri-di-lavoro-stato";
        return call_user_func([$this->httpClass, "post"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function postTaskNote($data)
    {
        $url = $this->baseUrl . "/task-note";
        return call_user_func([$this->httpClass, "post"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function postNotificaInviata($data)
    {
        $url = $this->baseUrl . "/notifiche-inviate";
        return call_user_func([$this->httpClass, "post"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function postOrario($data)
    {
        $url = $this->baseUrl . "/orari";
        return call_user_func([$this->httpClass, "post"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function postReparto($data)
    {
        $url = $this->baseUrl . "/reparti";
        return call_user_func([$this->httpClass, "post"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function postTurni($data)
    {
        $url = $this->baseUrl . "/turni";
        return call_user_func([$this->httpClass, "post"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function postSquadre($data)
    {
        $url = $this->baseUrl . "/squadre";
        return call_user_func([$this->httpClass, "post"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function postChat($data)
    {
        $url = $this->baseUrl . "/chat";
        return call_user_func([$this->httpClass, "post"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function postArtefatti($data)
    {
        $url = $this->baseUrl . "/artefatti";
        return call_user_func([$this->httpClass, "post"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function postEtichetteStampate($data)
    {
        $url = $this->baseUrl . "/etichette-stampate";
        return call_user_func([$this->httpClass, "post"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }










    public function deleteRunningTask($runningTaskId)
    {
        $data = ["RunningTaskId" => $runningTaskId];
        $url = $this->baseUrl . "/running-task";
        return call_user_func([$this->httpClass, "delete"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function deleteCentriDiLavoroIp($ip, $cdl = "")
    {
        $data = ["Ip" => $ip, "CodiceCdl" => $cdl];
        $url = $this->baseUrl . "/centri-di-lavoro-ip";
        return call_user_func([$this->httpClass, "delete"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function deleteDisintaBase($odl, $codiceArticolo = "", $codiceMateriale = "")
    {
        $data = ["CodiceOdl" => $odl, "CodiceArticolo" => $codiceArticolo, "CodiceMateriale" => $codiceMateriale];
        $url = $this->baseUrl . "/distinta-base";
        return call_user_func([$this->httpClass, "delete"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function deleteLotti($CodiceMateriale, $CodiceLotto = "")
    {
        $data = ["CodiceMateriale" => $CodiceMateriale, "CodiceLotto" => $CodiceLotto];
        $url = $this->baseUrl . "/lotti";
        return call_user_func([$this->httpClass, "delete"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function deleteGruppoScarto($CodiceGruppo)
    {
        $data = ["CodiceGruppo" => $CodiceGruppo];
        $url = $this->baseUrl . "/causali-scarto-gruppi";
        return call_user_func([$this->httpClass, "delete"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function deleteGruppoSospensione($CodiceGruppo)
    {
        $data = ["CodiceGruppo" => $CodiceGruppo];
        $url = $this->baseUrl . "/causali-sospensione-gruppi";
        return call_user_func([$this->httpClass, "delete"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function deleteReparto($Codice)
    {
        $data = ["CodiceReparto" => $Codice];
        $url = $this->baseUrl . "/reparti";
        return call_user_func([$this->httpClass, "delete"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function deleteRepartoOperatori($CodiceReparto)
    {
        $data = ["CodiceReparto" => $CodiceReparto];
        $url = $this->baseUrl . "/reparti-operatori";
        return call_user_func([$this->httpClass, "delete"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function deleteRepartoCentriDiLavoro($CodiceReparto)
    {
        $data = ["CodiceReparto" => $CodiceReparto];
        $url = $this->baseUrl . "/reparti-centri-di-lavoro";
        return call_user_func([$this->httpClass, "delete"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function deleteWebhook($id)
    {
        $data = ["Id" => $id];
        $url = $this->baseUrl . "/webhook";
        return call_user_func([$this->httpClass, "delete"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function deleteIfttt($id)
    {
        $data = ["Id" => $id];
        $url = $this->baseUrl . "/ifttt";
        return call_user_func([$this->httpClass, "delete"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function deleteCentriDiLavoroGruppi($CodiceGruppo)
    {
        $data = ["CodiceGruppo" => $CodiceGruppo];
        $url = $this->baseUrl . "/centri-di-lavoro-gruppi";
        return call_user_func([$this->httpClass, "delete"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function deleteRuolo($Codice)
    {
        $data = ["CodiceRuolo" => $Codice];
        $url = $this->baseUrl . "/ruoli";
        return call_user_func([$this->httpClass, "delete"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function deleteRuoloOperatori($CodiceRuolo = NULL, $CodiceOperatore = NULL)
    {
        if (!is_null($CodiceRuolo)) $data = ["CodiceRuolo" => $CodiceRuolo];
        elseif (!is_null($CodiceOperatore)) $data = ["CodiceOperatore" => $CodiceOperatore];
        $url = $this->baseUrl . "/ruoli-operatori";
        return call_user_func([$this->httpClass, "delete"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function deleteCdlOperatori($CodiceCdl)
    {
        $data = ["CodiceCdl" => $CodiceCdl];
        $url = $this->baseUrl . "/centri-di-lavoro-operatori";
        return call_user_func([$this->httpClass, "delete"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function deleteNotifica($codiceNotifica)
    {
        $data = ["CodiceNotifica" => $codiceNotifica];
        $url = $this->baseUrl . "/notifiche";
        return call_user_func([$this->httpClass, "delete"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function deleteOperatore($codiceOperatore)
    {
        $data = ["CodiceOperatore" => $codiceOperatore];
        $url = $this->baseUrl . "/operatori";
        return call_user_func([$this->httpClass, "delete"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function deleteSkill($Codice)
    {
        $data = ["CodiceSkill" => $Codice];
        $url = $this->baseUrl . "/skill";
        return call_user_func([$this->httpClass, "delete"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function deleteSkillOperatori($CodiceSkill = NULL, $CodiceOperatore = NULL)
    {
        if (!is_null($CodiceSkill)) $data = ["CodiceSkill" => $CodiceSkill];
        elseif (!is_null($CodiceOperatore)) $data = ["CodiceOperatore" => $CodiceOperatore];
        $url = $this->baseUrl . "/skill-operatori";
        return call_user_func([$this->httpClass, "delete"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function deleteOrario($Codice)
    {
        $data = ["CodiceOrario" => $Codice];
        $url = $this->baseUrl . "/orari";
        return call_user_func([$this->httpClass, "delete"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function deleteTurno($Codice)
    {
        $data = ["CodiceTurno" => $Codice];
        $url = $this->baseUrl . "/turni";
        return call_user_func([$this->httpClass, "delete"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function deleteSquadra($Codice)
    {
        $data = ["CodiceSquadra" => $Codice];
        $url = $this->baseUrl . "/squadre";
        return call_user_func([$this->httpClass, "delete"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function deleteProtocolliMisurazioni($id)
    {
        $data = ["id" => $id];
        $url = $this->baseUrl . "/protocolli-misurazioni";
        return call_user_func([$this->httpClass, "delete"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function deleteCentriDiLavoroProtocolliMisurazioni($id)
    {
        $data = ["id" => $id];
        $url = $this->baseUrl . "/centri-di-lavoro-protocolli-misurazioni";
        return call_user_func([$this->httpClass, "delete"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function deleteStoricoMisurazioniUltimi($date)
    {
        $data = ["dateIso" => $date];
        $url = $this->baseUrl . "/storico-misurazioni-ultimi";
        return call_user_func([$this->httpClass, "delete"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function deleteStoricoMisurazioniBufferItem($protocol, $item, $endpoint)
    {
        $data = ["protocol" => $protocol, "item" => $item, "endpoint" => $endpoint];
        $url = $this->baseUrl . "/storico-misurazioni-buffer-item";
        return call_user_func([$this->httpClass, "delete"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function deleteStoricoMisurazioniBufferItemIso($protocol, $item, $endpoint, $dateIso)
    {
        $data = ["protocol" => $protocol, "item" => $item, "endpoint" => $endpoint, "dateIso" => $dateIso];
        $url = $this->baseUrl . "/storico-misurazioni-buffer-item-date-iso";
        return call_user_func([$this->httpClass, "delete"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function deleteStoricoMisurazioniBufferUltimi($date)
    {
        $data = ["dateIso" => $date];
        $url = $this->baseUrl . "/storico-misurazioni-buffer-ultimi";
        return call_user_func([$this->httpClass, "delete"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function deleteTask($codiceOdl, $codiceFase)
    {
        $data = ["CodiceOdl" => $codiceOdl, "CodiceFase" => $codiceFase];
        $url = $this->baseUrl . "/task";
        return call_user_func([$this->httpClass, "delete"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function deleteTaskNoteErp($id)
    {
        $data = ["Id" => $id];
        $url = $this->baseUrl . "/task-note-erp";
        return call_user_func([$this->httpClass, "delete"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function deleteDistintaBaseUsata($id)
    {
        $data = [["Id" => $id]];
        $url = $this->baseUrl . "/distinta-base-usata";
        return call_user_func([$this->httpClass, "delete"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function deleteCausaliProduzione($codiceCausale)
    {
        $data = ["CodiceCausale" => $codiceCausale];
        $url = $this->baseUrl . "/causali-produzione";
        return call_user_func([$this->httpClass, "delete"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function deleteImpianti($Codice)
    {
        $data = ["CodiceImpianto" => $Codice];
        $url = $this->baseUrl . "/impianti";
        return call_user_func([$this->httpClass, "delete"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function deleteStabilimenti($Codice)
    {
        $data = ["CodiceStabilimento" => $Codice];
        $url = $this->baseUrl . "/stabilimenti";
        return call_user_func([$this->httpClass, "delete"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function deleteNodi($Codice)
    {
        $data = ["CodiceNodo" => $Codice];
        $url = $this->baseUrl . "/nodi";
        return call_user_func([$this->httpClass, "delete"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }

    public function deleteCentriDiLavoroRegoleMisurazioniConsumi($uuid)
    {
        $data = ["Uuid" => $uuid];
        $url = $this->baseUrl . "/centri-di-lavoro-regole-misurazioni-consumi";
        return call_user_func([$this->httpClass, "delete"], $url, $data, "application/json", ["Authorization: " . $this->authToken]);
    }









    /**
     * da vedere
     */

    public function getUbicazione($ubicazione)
    {
        $url = $this->baseUrl . "/getUbicazione/" . $ubicazione;
        return call_user_func([$this->httpClass, "get"], $url, ["Authorization: " . $this->authToken]);
    }

    public function getNumeroFigure($articolo)
    {
        $url = $this->baseUrl . "/getNumeroFigure/" . $articolo;
        return call_user_func([$this->httpClass, "get"], $url, ["Authorization: " . $this->authToken]);
    }

    public function getQOrdQRes($id)
    {
        $url = $this->baseUrl . "/getQOrdQRes/" . $id;
        return call_user_func([$this->httpClass, "get"], $url, ["Authorization: " . $this->authToken]);
    }

    public function getQProdottaScarto($id)
    {
        $url = $this->baseUrl . "/getQProdottaScarto/" . $id;
        return call_user_func([$this->httpClass, "get"], $url, ["Authorization: " . $this->authToken]);
    }

    public function getConsegna($id)
    {
        $url = $this->baseUrl . "/getConsegna/" . $id;
        return call_user_func([$this->httpClass, "get"], $url, ["Authorization: " . $this->authToken]);
    }
}
