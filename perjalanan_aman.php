<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Perjalanan extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->data['current'] = 'perjalanan';
        $this->data['destinasi'] = $this->destination->get();
        $params = array('server_key' => 'Mid-server-9tqRJg0U818xh-ryV2QIBRDO', 'production' => true);
        $this->load->library('midtrans');
        $this->midtrans->config($params);
    }

    public function index()
    {
        $this->data['title'] = 'Perjalanan';
        $this->load->view('rdpl/perjalanan/index', $this->data);
    }
    
    public function testing()
    {
        $this->data['title'] = 'Perjalanan Untuk Testing';
        $this->load->view('rdpl/perjalanan/index_testing', $this->data);
    }

    public function jam()
    {
        $now = date('Hi');
        $tgl = $_GET["tgl"];
        $asal = $_GET["asal"];
        $tujuan = $_GET["tujuan"];
        $kode_travel = $this->travel->get_kode_travel($asal, $tujuan);
        $id_travel = $this->travel->get_id_travel($asal, $tujuan);
        $result = $this->penjadwalan->get_jadwal($id_travel, $kode_travel, $tgl);
        if (!$result) {
            echo "-- Hasil pencarian tidak ditemukan --";
        } else {
            foreach ($result as $r) {
                if ($asal == '4' && $tujuan == '3') {
                    $nw = explode('.', $r->jam_berangkat);
                    $now2 = $nw[0] . $nw[1];
                    if ((int)$nw[0] < 9) {
                        $jknw = '0'.((int)$nw[0] + 1).'.'.$nw[1];
                    } else {
                        $jknw = ((int)$nw[0] + 1).'.'.$nw[1];
                    }
                    if (empty($r->jumlah_kursi)) {
                        echo "<tr><td class='TCenter'><label class='radio-inline'><input type='radio' name='codeticket' id='codeticket' disabled value='" . $r->id . "'></label></td><td class='TCenter' style='width:40;color:red;font-weight:bold'><div class='row'><div class='col'>" . $r->jam_berangkat . " WIB (Kursi habis)</div></div><div class='row'><div class='col'>Cianjur-Bandung " . $jknw . " WIB (Kursi habis)</div></div></td></tr>";
                    } elseif ($r->jumlah_kursi < 4) {
                        $vehicle     = $this->travel->get_vehicle_name($r->vehicle_id);
                        echo "<tr><td class='TCenter'><label class='radio-inline'><input type='radio' name='codeticket' id='codeticket' value='" . $r->id . "'></label></td><td class='TCenter' style='width:40;color:green;font-weight:bold'><div class='row'><div class='col'>" . $r->jam_berangkat . " WIB (Tersedia " . $r->jumlah_kursi . " kursi / " . $vehicle . ")</div></div><div class='row'><div class='col'>Cianjur-Bandung " . $jknw . " WIB (Tersedia " . $r->jumlah_kursi . " kursi / " . $vehicle . ")</div></div></td></tr>";
                    } else {
                        $vehicle     = $this->travel->get_vehicle_name($r->vehicle_id);
                        echo "<tr><td class='TCenter'><label class='radio-inline'><input type='radio' name='codeticket' id='codeticket' value='" . $r->id . "'></label></td><td class='TCenter' style='width:40'><div class='row'><div class='col'>" . $r->jam_berangkat . " WIB (Tersedia " . $r->jumlah_kursi . " kursi / " . $vehicle . ")</div></div><div class='row'><div class='col'>Cianjur-Bandung " . $jknw . " WIB (Tersedia " . $r->jumlah_kursi . " kursi / " . $vehicle . ")</div></div></td></tr>";
                    }
                } else {
                    $nw = explode('.', $r->jam_berangkat);
                    $now2 = $nw[0] . $nw[1];
                    if (empty($r->jumlah_kursi)) {
                        echo "<tr><td class='TCenter'><label class='radio-inline'><input type='radio' name='codeticket' id='codeticket' disabled value='" . $r->id . "'></label></td><td class='TCenter' style='width:40;color:red;font-weight:bold'>" . $r->jam_berangkat . " WIB (Kursi habis)</td></tr>";
                    } elseif ($r->jumlah_kursi < 4) {
                        $vehicle     = $this->travel->get_vehicle_name($r->vehicle_id);
                        echo "<tr><td class='TCenter'><label class='radio-inline'><input type='radio' name='codeticket' id='codeticket' value='" . $r->id . "'></label></td><td class='TCenter' style='width:40;color:green;font-weight:bold'>" . $r->jam_berangkat . " WIB (Tersedia " . $r->jumlah_kursi . " kursi / " . $vehicle . ")</td></tr>";
                    } else {
                        $vehicle     = $this->travel->get_vehicle_name($r->vehicle_id);
                        echo "<tr><td class='TCenter'><label class='radio-inline'><input type='radio' name='codeticket' id='codeticket' value='" . $r->id . "'></label></td><td class='TCenter' style='width:40'>" . $r->jam_berangkat . " WIB (Tersedia " . $r->jumlah_kursi . " kursi / " . $vehicle . ")</td></tr>";
                    }
                }
            }
        }
    }
    
    public function jam_testing()
    {
        $now = date('Hi');
        $tgl = $_GET["tgl"];
        $asal = $_GET["asal"];
        $tujuan = $_GET["tujuan"];
        $kode_travel = $this->travel->get_kode_travel($asal, $tujuan);
        $id_travel = $this->travel->get_id_travel($asal, $tujuan);
        $result = $this->penjadwalan->get_jadwal($id_travel, $kode_travel, $tgl);
        // $check = $this->
        if (!$result) {
            echo "-- Hasil pencarian tidak ditemukan --";
        } else {
            foreach ($result as $r) {
                $check = $this->travel->get_check_point($kode_travel);
                if (count($check) > 0) {
                    // $nw = explode('.', $r->jam_berangkat);
                    // $now2 = $nw[0] . $nw[1];
                    // if ((int)$nw[0] < 9) {
                    //     $jknw = '0'.((int)$nw[0] + 1).'.'.$nw[1];
                    // } else {
                    //     $jknw = ((int)$nw[0] + 1).'.'.$nw[1];
                    // }
                    if (empty($r->jumlah_kursi)) {
                        $htmll = "<tr><td class='TCenter' style='vertical-align:middle;'><label class='radio-inline'><input type='radio' name='codeticket' id='codeticket' disabled value='" . $r->id . "'></label></td><td class='TCenter' style='width:40;color:red;font-weight:bold'><div class='row d-flex justify-content-between'><div class='col-4'>" . $this->pool->get_nama($asal) . "</div><div class='col'>" . $r->jam_berangkat . " WIB (Kursi habis)</div></div>";
                        foreach ($check as $key => $value) {
                            $time = strtotime($r->jam_berangkat) + (int)$value['departure_time'];
                            $jknw = date('H:i', $time);
                            $htmll .= "<div class='row'><div class='col-4'>". $this->pool->get_nama($value['start_point']). "</div><div class='col'>". $jknw . " WIB (Kursi habis)</div></div>";
                        }
                        $htmll .= "</td></tr>";
                        echo $htmll;
                    } elseif ($r->jumlah_kursi < 4) {
                        $vehicle     = $this->travel->get_vehicle_name($r->vehicle_id);
                        $htmll = "<tr><td class='TCenter' style='vertical-align:middle;'><label class='radio-inline'><input type='radio' name='codeticket' id='codeticket' value='" . $r->id . "'></label></td><td class='TCenter' style='width:40;color:green;font-weight:bold'><div class='row'><div class='col-4'>" . $this->pool->get_nama($asal) . "</div><div class='col'>" . $r->jam_berangkat . " WIB (Tersedia " . $r->jumlah_kursi . " kursi / " . $vehicle . ")</div></div>";
                        foreach ($check as $key => $value) {
                            $time = strtotime($r->jam_berangkat) + (int)$value['departure_time'];
                            $jknw = date('H:i', $time);
                            $htmll .= "<div class='row'><div class='col-4'>" . $this->pool->get_nama($value['start_point']) . "</div><div class='col'>" . $jknw . " WIB (Tersedia " . $r->jumlah_kursi . " kursi / " . $vehicle . ")</div></div>";
                        };
                        $htmll .= "</td></tr>";
                        echo $htmll;
                    } else {
                        $vehicle     = $this->travel->get_vehicle_name($r->vehicle_id);
                        $htmll = "<tr><td class='TCenter' style='vertical-align:middle;'><label class='radio-inline'><input type='radio' name='codeticket' id='codeticket' value='" . $r->id . "'></label></td><td class='TCenter' style='width:40'><div class='row'><div class='col-4'>" . $this->pool->get_nama($asal) . "</div><div class='col'>" . $r->jam_berangkat . " WIB (Tersedia " . $r->jumlah_kursi . " kursi / " . $vehicle . ")</div></div>";
                        foreach ($check as $key => $value) {
                            $time = strtotime($r->jam_berangkat) + (int)$value['departure_time'];
                            $jknw = date('H:i', $time);
                            $htmll .= "<div class='row'><div class='col-4'>" . $this->pool->get_nama($value['start_point']) . "</div><div class='col'>" . $jknw . " WIB (Tersedia " . $r->jumlah_kursi . " kursi / " . $vehicle . ")</div></div>";
                        };
                        $htmll .= "</td></tr>";
                        echo $htmll;
                    }
                } else {
                    $nw = explode('.', $r->jam_berangkat);
                    $now2 = $nw[0] . $nw[1];
                    if (empty($r->jumlah_kursi)) {
                        echo "<tr><td class='TCenter' style='vertical-align:middle;'><label class='radio-inline'><input type='radio' name='codeticket' id='codeticket' disabled value='" . $r->id . "'></label></td><td class='TCenter' style='width:40;color:red;font-weight:bold'>" . $r->jam_berangkat . " WIB (Kursi habis)</td></tr>";
                    } elseif ($r->jumlah_kursi < 4) {
                        $vehicle     = $this->travel->get_vehicle_name($r->vehicle_id);
                        echo "<tr><td class='TCenter' style='vertical-align:middle;'><label class='radio-inline'><input type='radio' name='codeticket' id='codeticket' value='" . $r->id . "'></label></td><td class='TCenter' style='width:40;color:green;font-weight:bold'>" . $r->jam_berangkat . " WIB (Tersedia " . $r->jumlah_kursi . " kursi / " . $vehicle . ")</td></tr>";
                    } else {
                        $vehicle     = $this->travel->get_vehicle_name($r->vehicle_id);
                        echo "<tr><td class='TCenter' style='vertical-align:middle;'><label class='radio-inline'><input type='radio' name='codeticket' id='codeticket' value='" . $r->id . "'></label></td><td class='TCenter' style='width:40'>" . $r->jam_berangkat . " WIB (Tersedia " . $r->jumlah_kursi . " kursi / " . $vehicle . ")</td></tr>";
                    }
                }
                // if ($asal == '4' && $tujuan == '3') {
                //     $nw = explode('.', $r->jam_berangkat);
                //     $now2 = $nw[0] . $nw[1];
                //     if ((int)$nw[0] < 9) {
                //         $jknw = '0'.((int)$nw[0] + 1).'.'.$nw[1];
                //     } else {
                //         $jknw = ((int)$nw[0] + 1).'.'.$nw[1];
                //     }
                //     if (empty($r->jumlah_kursi)) {
                //         echo "<tr><td class='TCenter'><label class='radio-inline'><input type='radio' name='codeticket' id='codeticket' disabled value='" . $r->id . "'></label></td><td class='TCenter' style='width:40;color:red;font-weight:bold'><div class='row'><div class='col'>" . $r->jam_berangkat . " WIB (Kursi habis)</div></div><div class='row'><div class='col'>Cianjur-Bandung " . $jknw . " WIB (Kursi habis)</div></div></td></tr>";
                //     } elseif ($r->jumlah_kursi < 4) {
                //         $vehicle     = $this->travel->get_vehicle_name($r->vehicle_id);
                //         echo "<tr><td class='TCenter'><label class='radio-inline'><input type='radio' name='codeticket' id='codeticket' value='" . $r->id . "'></label></td><td class='TCenter' style='width:40;color:green;font-weight:bold'><div class='row'><div class='col'>" . $r->jam_berangkat . " WIB (Tersedia " . $r->jumlah_kursi . " kursi / " . $vehicle . ")</div></div><div class='row'><div class='col'>Cianjur-Bandung " . $jknw . " WIB (Tersedia " . $r->jumlah_kursi . " kursi / " . $vehicle . ")</div></div></td></tr>";
                //     } else {
                //         $vehicle     = $this->travel->get_vehicle_name($r->vehicle_id);
                //         echo "<tr><td class='TCenter'><label class='radio-inline'><input type='radio' name='codeticket' id='codeticket' value='" . $r->id . "'></label></td><td class='TCenter' style='width:40'><div class='row'><div class='col'>" . $r->jam_berangkat . " WIB (Tersedia " . $r->jumlah_kursi . " kursi / " . $vehicle . ")</div></div><div class='row'><div class='col'>Cianjur-Bandung " . $jknw . " WIB (Tersedia " . $r->jumlah_kursi . " kursi / " . $vehicle . ")</div></div></td></tr>";
                //     }
                // } else {
                //     $nw = explode('.', $r->jam_berangkat);
                //     $now2 = $nw[0] . $nw[1];
                //     if (empty($r->jumlah_kursi)) {
                //         echo "<tr><td class='TCenter'><label class='radio-inline'><input type='radio' name='codeticket' id='codeticket' disabled value='" . $r->id . "'></label></td><td class='TCenter' style='width:40;color:red;font-weight:bold'>" . $r->jam_berangkat . " WIB (Kursi habis)</td></tr>";
                //     } elseif ($r->jumlah_kursi < 4) {
                //         $vehicle     = $this->travel->get_vehicle_name($r->vehicle_id);
                //         echo "<tr><td class='TCenter'><label class='radio-inline'><input type='radio' name='codeticket' id='codeticket' value='" . $r->id . "'></label></td><td class='TCenter' style='width:40;color:green;font-weight:bold'>" . $r->jam_berangkat . " WIB (Tersedia " . $r->jumlah_kursi . " kursi / " . $vehicle . ")</td></tr>";
                //     } else {
                //         $vehicle     = $this->travel->get_vehicle_name($r->vehicle_id);
                //         echo "<tr><td class='TCenter'><label class='radio-inline'><input type='radio' name='codeticket' id='codeticket' value='" . $r->id . "'></label></td><td class='TCenter' style='width:40'>" . $r->jam_berangkat . " WIB (Tersedia " . $r->jumlah_kursi . " kursi / " . $vehicle . ")</td></tr>";
                //     }
                // }
            }
        }
    }

    public function jame()
    {
        $now = date('Hi');
        $tgl = $_GET["tgl"];
        $kode_travel = $_GET["travel"];
        $result = $this->penjadwalan->get_jadwal($kode_travel, $kode_travel, $tgl);
        if (!$result) {
            echo "-- Hasil pencarian tidak ditemukan --";
        } else {
            foreach ($result as $r) {
                $nw = explode('.', $r->jam_berangkat);
                $now2 = $nw[0] . $nw[1];
                if (empty($r->jumlah_kursi)) {
                    echo "<tr><td class='TCenter'><label class='radio-inline'><input type='radio' name='codeticket' id='codeticket' disabled value='" . $r->id . "'></label></td><td class='TCenter' style='width:40;color:red;font-weight:bold'>" . $r->jam_berangkat . " WIB (Kursi habis)</td></tr>";
                } elseif ($r->jumlah_kursi < 4) {
                    echo "<tr><td class='TCenter'><label class='radio-inline'><input type='radio' name='codeticket' id='codeticket' value='" . $r->id . "'></label></td><td class='TCenter' style='width:40;color:green;font-weight:bold'>" . $r->jam_berangkat . " WIB (Tersedia " . $r->jumlah_kursi . " kursi)</td></tr>";
                } else {
                    echo "<tr><td class='TCenter'><label class='radio-inline'><input type='radio' name='codeticket' id='codeticket' value='" . $r->id . "'></label></td><td class='TCenter' style='width:40'>" . $r->jam_berangkat . " WIB (Tersedia " . $r->jumlah_kursi . " kursi)</td></tr>";
                }
            }
        }
    }

    public function jam2()
    {
        $now = date('Hi');
        $tgl = $_GET["tgl"];
        $asal = $_GET["asal"];
        $tujuan = $_GET["tujuan"];
        $kode_travel = $this->travel->get_kode_travel($asal, $tujuan);
        $id_travel = $this->travel->get_id_travel($asal, $tujuan);
        $result = $this->penjadwalan->get_jadwal($id_travel, $kode_travel, $tgl);
        if (!$result) {
            echo "-- Hasil pencarian tidak ditemukan --";
        } else {
            foreach ($result as $r) {
                $nw = explode('.', $r->jam_berangkat);
                $now2 = $nw[0] . $nw[1];
                if (empty($r->jumlah_kursi)) {
                    echo "<tr><td class='TCenter'><label class='radio-inline'><input type='radio' name='codeticket2' id='codeticket2' disabled value='" . $r->id . "'></label></td><td class='TCenter' style='width:40;color:red;font-weight:bold'>" . $r->jam_berangkat . " WIB (Kursi habis)</td></tr>";
                } elseif ($r->jumlah_kursi < 4) {
                    echo "<tr><td class='TCenter'><label class='radio-inline'><input type='radio' name='codeticket2' id='codeticket2' value='" . $r->id . "'></label></td><td class='TCenter' style='width:40;color:green;font-weight:bold'>" . $r->jam_berangkat . " WIB (Tersedia " . $r->jumlah_kursi . " kursi)</td></tr>";
                } else {
                    echo "<tr><td class='TCenter'><label class='radio-inline'><input type='radio' name='codeticket2' id='codeticket2' value='" . $r->id . "'></label></td><td class='TCenter' style='width:40'>" . $r->jam_berangkat . " WIB (Tersedia " . $r->jumlah_kursi . " kursi)</td></tr>";
                }
            }
        }
    }
    
    public function jam2_testing()
    {
        $now = date('Hi');
        $tgl = $_GET["tgl"];
        $asal = $_GET["asal"];
        $tujuan = $_GET["tujuan"];
        $kode_travel = $this->travel->get_kode_travel($asal, $tujuan);
        $id_travel = $this->travel->get_id_travel($asal, $tujuan);
        $result = $this->penjadwalan->get_jadwal($id_travel, $kode_travel, $tgl);
        if (!$result) {
            echo "-- Hasil pencarian tidak ditemukan --";
        } else {
            foreach ($result as $r) {
                $check = $this->travel->get_check_point($kode_travel);
                if (count($check) > 0) {
                    // $nw = explode('.', $r->jam_berangkat);
                    // $now2 = $nw[0] . $nw[1];
                    // if ((int)$nw[0] < 9) {
                    //     $jknw = '0'.((int)$nw[0] + 1).'.'.$nw[1];
                    // } else {
                    //     $jknw = ((int)$nw[0] + 1).'.'.$nw[1];
                    // }
                    if (empty($r->jumlah_kursi)) {
                        $htmll = "<tr><td class='TCenter' style='vertical-align:middle;'><label class='radio-inline'><input type='radio' name='codeticket2' id='codeticket2' disabled value='" . $r->id . "'></label></td><td class='TCenter' style='width:40;color:red;font-weight:bold'><div class='row d-flex justify-content-between'><div class='col-4'>" . $this->pool->get_nama($asal) . "</div><div class='col'>" . $r->jam_berangkat . " WIB (Kursi habis)</div></div>";
                        foreach ($check as $key => $value) {
                            $time = strtotime($r->jam_berangkat) + (int)$value['departure_time'];
                            $jknw = date('H:i', $time);
                            $htmll .= "<div class='row'><div class='col-4'>". $this->pool->get_nama($value['start_point']). "</div><div class='col'>". $jknw . " WIB (Kursi habis)</div></div>";
                        }
                        $htmll .= "</td></tr>";
                        echo $htmll;
                    } elseif ($r->jumlah_kursi < 4) {
                        $vehicle     = $this->travel->get_vehicle_name($r->vehicle_id);
                        $htmll = "<tr><td class='TCenter' style='vertical-align:middle;'><label class='radio-inline'><input type='radio' name='codeticket2' id='codeticket2' value='" . $r->id . "'></label></td><td class='TCenter' style='width:40;color:green;font-weight:bold'><div class='row'><div class='col-4'>" . $this->pool->get_nama($asal) . "</div><div class='col'>" . $r->jam_berangkat . " WIB (Tersedia " . $r->jumlah_kursi . " kursi / " . $vehicle . ")</div></div>";
                        foreach ($check as $key => $value) {
                            $time = strtotime($r->jam_berangkat) + (int)$value['departure_time'];
                            $jknw = date('H:i', $time);
                            $htmll .= "<div class='row'><div class='col-4'>" . $this->pool->get_nama($value['start_point']) . "</div><div class='col'>" . $jknw . " WIB (Tersedia " . $r->jumlah_kursi . " kursi / " . $vehicle . ")</div></div>";
                        };
                        $htmll .= "</td></tr>";
                        echo $htmll;
                    } else {
                        $vehicle     = $this->travel->get_vehicle_name($r->vehicle_id);
                        $htmll = "<tr><td class='TCenter' style='vertical-align:middle;'><label class='radio-inline'><input type='radio' name='codeticket2' id='codeticket2' value='" . $r->id . "'></label></td><td class='TCenter' style='width:40'><div class='row'><div class='col-4'>" . $this->pool->get_nama($asal) . "</div><div class='col'>" . $r->jam_berangkat . " WIB (Tersedia " . $r->jumlah_kursi . " kursi / " . $vehicle . ")</div></div>";
                        foreach ($check as $key => $value) {
                            $time = strtotime($r->jam_berangkat) + (int)$value['departure_time'];
                            $jknw = date('H:i', $time);
                            $htmll .= "<div class='row'><div class='col-4'>" . $this->pool->get_nama($value['start_point']) . "</div><div class='col'>" . $jknw . " WIB (Tersedia " . $r->jumlah_kursi . " kursi / " . $vehicle . ")</div></div>";
                        };
                        $htmll .= "</td></tr>";
                        echo $htmll;
                    }
                } else {
                    $nw = explode('.', $r->jam_berangkat);
                    $now2 = $nw[0] . $nw[1];
                    if (empty($r->jumlah_kursi)) {
                        echo "<tr><td class='TCenter' style='vertical-align:middle;'><label class='radio-inline'><input type='radio' name='codeticket2' id='codeticket2' disabled value='" . $r->id . "'></label></td><td class='TCenter' style='width:40;color:red;font-weight:bold'><div class='row'><div class='col-4'>" . $this->pool->get_nama($asal) . "</div><div class='col'>" . $r->jam_berangkat . " WIB (Kursi habis)</div></div></td></tr>";
                    } elseif ($r->jumlah_kursi < 4) {
                        $vehicle     = $this->travel->get_vehicle_name($r->vehicle_id);
                        echo "<tr><td class='TCenter' style='vertical-align:middle;'><label class='radio-inline'><input type='radio' name='codeticket2' id='codeticket2' value='" . $r->id . "'></label></td><td class='TCenter' style='width:40;color:green;font-weight:bold'><div class='row'><div class='col-4'>" . $this->pool->get_nama($asal) . "</div><div class='col'>" . $r->jam_berangkat . " WIB (Tersedia " . $r->jumlah_kursi . " kursi / " . $vehicle . ")</div></div></td></tr>";
                    } else {
                        $vehicle     = $this->travel->get_vehicle_name($r->vehicle_id);
                        echo "<tr><td class='TCenter' style='vertical-align:middle;'><label class='radio-inline'><input type='radio' name='codeticket2' id='codeticket2' value='" . $r->id . "'></label></td><td class='TCenter' style='width:40'><div class='row'><div class='col-4'>" . $this->pool->get_nama($asal) . "</div><div class='col'>" . $r->jam_berangkat . " WIB (Tersedia " . $r->jumlah_kursi . " kursi / " . $vehicle . ")</div></div></td></tr>";
                    }
                }
            }
        }
    }

    public function rute()
    {
        $asal = $_GET["asal"];
        $tujuan = $_GET["tujuan"];
        $id_travel = $this->travel->get_id_travel($asal, $tujuan);
        $result = $this->destination->get_by(array('id_travel' => $id_travel));
        if (!$result) {
            echo "<option value=''>-- Hasil pencarian tidak ditemukan --</option>";
        } else {
            echo "<option value=''>-- Pilih Rute Perjalanan --</option>";
            foreach ($result as $r) {
                echo "<option value='" . $r->id . "'>" . ucfirst($r->deskripsi) . "</option>";
            }
        }
    }
    
    public function rute_testing()
    {
        $asal = $_GET["asal"];
        $tujuan = $_GET["tujuan"];
        $id_travel = $this->travel->get_id_travel($asal, $tujuan);
        $result = $this->destination->get_by(array('id_travel' => $id_travel));
        if (!$result) {
            echo "<option value=''>-- Hasil pencarian tidak ditemukan --</option>";
        } else {
            echo "<option value=''>-- Pilih Rute Perjalanan --</option>";
            foreach ($result as $r) {
                echo "<option value='" . $r->id . "'>" . ucfirst($r->deskripsi) . "</option>";
            }
        }
    }

    public function ajax_index()
    {
        $list = $this->perjalanan->get_latest();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $perjalanan) {
            $waktu_berangkat = explode(' ', $perjalanan->waktu_berangkat);
            $pesan = explode(' ', $perjalanan->created);
            $tglx = explode('-', $waktu_berangkat[0]);
            $wktx = explode(':', $waktu_berangkat[1]);
            $wx = date('YmdHis');
            $wz = $tglx . $wktx;
            if ($perjalanan->status_bayar == 'belum lunas') {
                $btn = "<div class='btn-group' id='" . $perjalanan->id . "'>";
                if ($this->session->userdata('pool_id')!== '0') {
                    if (explode("-",$perjalanan->destination)[0] == 'BDG') {
                        if ($this->session->userdata('pool_id') == '3') {
                            $btn .= "<a href='" . base_url('rdpl/perjalanan/bayar/' . $perjalanan->id) . "' class='btn btn-primary'><i class='fa fa-cash-register'></i></a>";
                        }
                    } elseif (explode("-",$perjalanan->destination)[0] == 'SMI') {
                        if ($this->session->userdata('pool_id') == '4') {
                            $btn .= "<a href='" . base_url('rdpl/perjalanan/bayar/' . $perjalanan->id) . "' class='btn btn-primary'><i class='fa fa-cash-register'></i></a>";
                        }
                    } elseif (explode("-",$perjalanan->destination)[0] == 'CJR') {
                        if ($this->session->userdata('pool_id') == '13') {
                            $btn .= "<a href='" . base_url('rdpl/perjalanan/bayar/' . $perjalanan->id) . "' class='btn btn-primary'><i class='fa fa-cash-register'></i></a>";
                        }
                    } elseif (explode("-",$perjalanan->destination)[0] == 'JKT') {
                        if ($this->session->userdata('pool_id') == '16') {
                            $btn .= "<a href='" . base_url('rdpl/perjalanan/bayar/' . $perjalanan->id) . "' class='btn btn-primary'><i class='fa fa-cash-register'></i></a>";
                        }
                    } elseif (explode("-",$perjalanan->destination)[0] == 'SBG') {
                        if ($this->session->userdata('pool_id') == '21') {
                            $btn .= "<a href='" . base_url('rdpl/perjalanan/bayar/' . $perjalanan->id) . "' class='btn btn-primary'><i class='fa fa-cash-register'></i></a>";
                        }
                    }

                    if ($this->session->userdata['id'] == "76" || $this->session->userdata['group_id'] == "1" && $wx < $wz && $perjalanan->cetak == "0") {
                        $btn .= "<a href='" . base_url('rdpl/perjalanan/edit/' . $perjalanan->id) . "' class='btn btn-success'><i class='fa fa-edit'></i></a>";
                    }
                } else {
                    $btn .= "<a href='" . base_url('rdpl/perjalanan/bayar/' . $perjalanan->id) . "' class='btn btn-primary'><i class='fa fa-cash-register'></i></a>";
                    if ($this->session->userdata['id'] == "76" || $this->session->userdata['group_id'] == "1" && $wx < $wz && $perjalanan->cetak == "0") {
                        $btn .= "<a href='" . base_url('rdpl/perjalanan/edit/' . $perjalanan->id) . "' class='btn btn-success'><i class='fa fa-edit'></i></a>";
                    }
                }
                $btn .= "<button type='button' data-target='rdpl/perjalanan/batal' data-id='" . $perjalanan->id . "' onclick='deletethis(this)' class='btn btn-danger'><i class='fa fa-times'></i></button>";
                /* $btn .= "<a href='".base_url('rdpl/perjalanan/pindah/'.$perjalanan->id)."' class='dropdown-item'>Pindah</a>";
                $btn .= "<a href='".base_url('rdpl/perjalanan/salah/'.$perjalanan->id)."' class='dropdown-item'>Salah</a>"; */
                $btn .= "</div>";
                $check = '<input type="checkbox" value="' . $perjalanan->id . '" name="myCheckboxes[]" class="act" id="myCheckboxes">';
                $stt = label_grey(ucfirst($perjalanan->status_bayar));
            } else {
                $btn = "<div class='btn-group' id='" . $perjalanan->id . "'>";
                if ($this->session->userdata['id'] == "76" || $this->session->userdata['group_id'] == "1" && $wx < $wz && $perjalanan->cetak == "0") {
                    $btn .= "<a href='" . base_url('rdpl/perjalanan/edit/' . $perjalanan->id) . "' class='btn btn-primary'><i class='fa fa-edit'></i></a>";
                }
                $btn .= "<a href='#' onClick='popup_print(this)' data-id='" . $perjalanan->id . "' class='btn btn-success'><i class='fa fa-ticket-alt'></i></a>";
                $btn .= "</div>";
                $check = '';
                $stt = label_green(ucfirst($perjalanan->status_bayar));
            }
            /* if($perjalanan->id_payment != "0") {
                $stmid = $this->midtrans->status($perjalanan->id_payment)->transaction_status;
                $pymid = $this->midtrans->status($perjalanan->id_payment)->payment_type;
                if($stmid == "expire") {
                    $this->batalx($perjalanan->id);
                    $smid = label_green(ucfirst($stmid).' / '.ucfirst($pymid));
                    $btn = label_grey(ucfirst($stmid));
                } else if($stmid == "settlement" || $stmid == "capture") {
                    $this->lunasx($perjalanan->id);
                    $smid = label_green(ucfirst($stmid).' / '.ucfirst($pymid));
                    $stt = label_green('Lunas');
                    $btn = "<a href='#' onClick='popup_print(this)' data-id='".$perjalanan->id."' class='btn btn-success'><i class='fa fa-ticket-alt'></i></a>";
                } else if($stmid == "pending") {
                    $smid = label_grey(ucfirst($stmid).' / '.ucfirst($pymid));
                    $btn = label_grey(ucfirst($stmid));
                } else {
                    $smid = label_green(ucfirst($stmid).' / '.ucfirst($pymid));
                }
                $mid = $perjalanan->id_payment.'<br/>'.$smid;
            } else {
                $mid = "";
            } */
            $mid = $perjalanan->id_payment;
            $row = array();
            $row[] = $check;
            $row[] = $perjalanan->id;
            $row[] = $mid;
            $row[] = $perjalanan->nama_pemesan . "<br/>" . $perjalanan->no_hp;
            if ($perjalanan->id_destination == '2') {
                $jam_berangkatt = explode('.', $waktu_berangkat[1]);
                if ($jam_berangkatt[0] < 9) {
                    $jam_berangkat = '0'. ($jam_berangkatt[0] + 1) . '.' . $jam_berangkatt[1];
                } else {
                    $jam_berangkat = $jam_berangkatt[0] + 1 . '.' . $jam_berangkatt[1];
                }
            } else {
                $jam_berangkat = $waktu_berangkat[1];
            }
            $row[] = $perjalanan->destination . " / Kursi " . $perjalanan->kode_kursi . "<br/><small>" . date_format_id($waktu_berangkat[0]) . " " . $jam_berangkat . " WIB</small>";
            $row[] = 'Rp. ' . number_format($perjalanan->total_bayar) . "<br/>" . $stt;
            $row[] = 'Rp. ' . number_format($perjalanan->diskon);
            $row[] = $perjalanan->created_by . "<br/><small>" . date_format_id($pesan[0]) . " " . $pesan[1] . " WIB</small>";
            $row[] = $btn;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->perjalanan->count_latest_all(),
            "recordsFiltered" => $this->perjalanan->count_latest_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function pelanggan()
    {
        if ($this->session->userdata('group_id') != 1) {
            $this->session->set_flashdata('warning', msg_error("Anda tidak diizinkan mengakses halaman ini"));
            redirect('rdpl/perjalanan');
        } else {
            $this->data['title'] = 'Data Pelanggan Perjalanan';
            $this->load->view('rdpl/perjalanan/pelanggan', $this->data);
        }
    }

    public function ajax_pelanggan()
    {
        $list = $this->perjalanan->get_pelanggan();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $perjalanan) {
            $btn = "<a href='" . base_url('rdpl/perjalanan/detail_pelanggan/' . $perjalanan->no_hp) . "' class='btn btn-success btn-block'>Lihat Detail</a>";
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $perjalanan->no_hp;
            $row[] = $perjalanan->nama_pemesan;
            $row[] = $this->perjalanan->get_pelangganss($perjalanan->no_hp);
            $row[] = $this->perjalanan->get_pelanggans($perjalanan->no_hp);
            $row[] = $btn;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->perjalanan->count_latest_all(),
            "recordsFiltered" => $this->perjalanan->count_pelanggan_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function detail_pelanggan($hp)
    {
        if ($this->session->userdata('group_id') != 1) {
            $this->session->set_flashdata('warning', msg_error("Anda tidak diizinkan mengakses halaman ini"));
            redirect('rdpl/perjalanan');
        } else {
            $this->data['title'] = 'Detail Data Pelanggan No. Telp/HP : ' . $hp;
            $this->data['hp'] = $hp;
            $this->load->view('rdpl/perjalanan/detail_pelanggan', $this->data);
        }
    }

    public function ajax_detail_pelanggan($hp)
    {
        $list = $this->perjalanan->get_pelanggan2($hp);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $perjalanan) {
            $waktu_berangkat = explode(' ', $perjalanan->waktu_berangkat);
            $pesan = explode(' ', $perjalanan->created);
            if ($perjalanan->status_bayar == 'belum lunas') {
                $btn = "<div class='dropdown'>";
                $btn .= "<button type='button' class='btn btn-secondary dropdown-toggle btn-block' id='btn" . $perjalanan->id . "' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>";
                $btn .= "<span data-bind='label'>-- Action --</span> <span class='caret'></span></button>";
                $btn .= "<div class='dropdown-menu' aria-labelledby='btn" . $perjalanan->id . "'>";
                $btn .= "<a href='" . base_url('rdpl/perjalanan/bayar/' . $perjalanan->id) . "' class='dropdown-item'>Bayar</a>";
                $btn .= "<a href='" . base_url('rdpl/perjalanan/batal/' . $perjalanan->id) . "' class='dropdown-item'>Batal</a>";
                /* $btn .= "<a href='".base_url('rdpl/perjalanan/pindah/'.$perjalanan->id)."' class='dropdown-item'>Pindah</a>";
                $btn .= "<a href='".base_url('rdpl/perjalanan/salah/'.$perjalanan->id)."' class='dropdown-item'>Salah</a>"; */
                $btn .= "</div></div>";
            } else {
                $btn = "<a href='#' onClick='popup_print(this)' data-id='" . $perjalanan->id . "' class='btn btn-success btn-block'>Tiket</a>";
            }
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $perjalanan->id;
            $row[] = $perjalanan->no_hp;
            $row[] = $perjalanan->nama_pemesan;
            $row[] = $perjalanan->destination;
            $row[] = $waktu_berangkat[1];
            $row[] = $perjalanan->kode_kursi;
            $row[] = 'Rp. ' . number_format($perjalanan->total_bayar);
            $row[] = $perjalanan->status_bayar;
            $row[] = $perjalanan->created_by;
            $row[] = date_format_id($pesan[0]) . "<br/>" . $pesan[1];
            $row[] = $btn;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->perjalanan->count_latest_all(),
            "recordsFiltered" => $this->perjalanan->count_pelanggan2_filtered($hp),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function cetakpelanggan()
    {
        $this->db->from('st_data_perjalanan');
        //add custom filter here
        $this->db->group_by('no_hp');
        if ($this->input->post('no_hp')) {
            $this->db->like('no_hp', $this->input->post('no_hp'));
        }
        if ($this->input->post('nama_pemesan')) {
            $this->db->like('nama_pemesan', $this->input->post('nama_pemesan'));
        }
        if ($this->input->post('status')) {
            if ($this->input->post('status') == "a") {
                $this->db->having('COUNT(no_hp) >', 25);
            } elseif ($this->input->post('status') == "b") {
                $this->db->having('COUNT(no_hp) >', 50);
            } elseif ($this->input->post('status') == "c") {
                $this->db->having('COUNT(no_hp) >', 100);
            }
        }
        $this->db->order_by('created', 'desc');
        $query = $this->db->get();
        $results = $query->result();
        $data = array();
        foreach ($results as $perjalanan) {
            $data[] = array(
                'hp'          => $perjalanan->no_hp,
                'nama'       => $perjalanan->nama_pemesan,
                'perjalanan' => $this->perjalanan->get_pelangganss($perjalanan->no_hp),
                'kursi'     => $this->perjalanan->get_pelanggans($perjalanan->no_hp)
            );
        }
        $this->data['reservation'] = $data;
        $this->db->order_by('date(waktu_berangkat)', 'desc');
        $this->load->view('rdpl/perjalanan/cetakpelanggan', $this->data);
    }

    public function data()
    {
        if ($_POST['tgl_awal']) {
            $this->data['tgl_awal'] = $_POST['tgl_awal'];
        } else {
            $this->data['tgl_awal'] = date('Y-m-d', strtotime('-2 months'));
        }
        if ($_POST['tgl_akhir']) {
            $this->data['tgl_akhir'] = $_POST['tgl_akhir'];
        } else {
            $this->data['tgl_akhir'] = date('Y-m-d', strtotime('+2 months'));
        }
        $this->data['title'] = 'Data Perjalanan';
        $this->load->view('rdpl/perjalanan/data', $this->data);
    }

    public function ajax_data()
    {
        $list = $this->perjalanan->get_data();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $perjalanan) {
            $waktu_berangkat = explode(' ', $perjalanan->waktu_berangkat);
            $pesan = explode(' ', $perjalanan->created);
            $tglx = explode('-', $waktu_berangkat[0]);
            $wktx = explode(':', $waktu_berangkat[1]);
            $wx = date('YmdHis');
            $wz = $tglx . $wktx;
            if ($perjalanan->status_bayar == 'belum lunas') {
                $btn = "<div class='btn-group' id='" . $perjalanan->id . "'>";
                if ($this->session->userdata('pool_id')!== '0') {
                    if (explode("-",$perjalanan->destination)[0] == 'BDG') {
                        if ($this->session->userdata('pool_id') == '3') {
                            $btn .= "<a href='" . base_url('rdpl/perjalanan/bayar/' . $perjalanan->id) . "' class='btn btn-primary'><i class='fa fa-cash-register'></i></a>";
                        }
                    } elseif (explode("-",$perjalanan->destination)[0] == 'SMI') {
                        if ($this->session->userdata('pool_id') == '4') {
                            $btn .= "<a href='" . base_url('rdpl/perjalanan/bayar/' . $perjalanan->id) . "' class='btn btn-primary'><i class='fa fa-cash-register'></i></a>";
                        }
                    } elseif (explode("-",$perjalanan->destination)[0] == 'CJR') {
                        if ($this->session->userdata('pool_id') == '13') {
                            $btn .= "<a href='" . base_url('rdpl/perjalanan/bayar/' . $perjalanan->id) . "' class='btn btn-primary'><i class='fa fa-cash-register'></i></a>";
                        }
                    } elseif (explode("-",$perjalanan->destination)[0] == 'JKT') {
                        if ($this->session->userdata('pool_id') == '16') {
                            $btn .= "<a href='" . base_url('rdpl/perjalanan/bayar/' . $perjalanan->id) . "' class='btn btn-primary'><i class='fa fa-cash-register'></i></a>";
                        }
                    } elseif (explode("-",$perjalanan->destination)[0] == 'SBG') {
                        if ($this->session->userdata('pool_id') == '21') {
                            $btn .= "<a href='" . base_url('rdpl/perjalanan/bayar/' . $perjalanan->id) . "' class='btn btn-primary'><i class='fa fa-cash-register'></i></a>";
                        }
                    }

                    if ($this->session->userdata['id'] == "76" || $this->session->userdata['group_id'] == "1" && $wx < $wz && $perjalanan->cetak == "0") {
                        $btn .= "<a href='" . base_url('rdpl/perjalanan/edit/' . $perjalanan->id) . "' class='btn btn-success'><i class='fa fa-edit'></i></a>";
                    }
                } else {
                    $btn .= "<a href='" . base_url('rdpl/perjalanan/bayar/' . $perjalanan->id) . "' class='btn btn-primary'><i class='fa fa-cash-register'></i></a>";
                    if ($this->session->userdata['id'] == "76" || $this->session->userdata['group_id'] == "1" && $wx < $wz && $perjalanan->cetak == "0") {
                        $btn .= "<a href='" . base_url('rdpl/perjalanan/edit/' . $perjalanan->id) . "' class='btn btn-success'><i class='fa fa-edit'></i></a>";
                    }
                }
                $btn .= "<button type='button' data-target='rdpl/perjalanan/batal' data-id='" . $perjalanan->id . "' onclick='deletethis(this)' class='btn btn-danger'><i class='fa fa-times'></i></button>";
                /* $btn .= "<a href='".base_url('rdpl/perjalanan/pindah/'.$perjalanan->id)."' class='dropdown-item'>Pindah</a>";
                $btn .= "<a href='".base_url('rdpl/perjalanan/salah/'.$perjalanan->id)."' class='dropdown-item'>Salah</a>"; */
                $btn .= "</div>";
                $check = '<input type="checkbox" value="' . $perjalanan->id . '" name="myCheckboxes[]" class="act" id="myCheckboxes">';
                $stt = label_grey(ucfirst($perjalanan->status_bayar));
            } else {
                $btn = "<div class='btn-group' id='" . $perjalanan->id . "'>";
                if ($this->session->userdata['id'] == "76" || $this->session->userdata['group_id'] == "1" && $wx < $wz && $perjalanan->cetak == "0") {
                    $btn .= "<a href='" . base_url('rdpl/perjalanan/edit/' . $perjalanan->id) . "' class='btn btn-primary'><i class='fa fa-edit'></i></a>";
                }
                $btn .= "<a href='#' onClick='popup_print(this)' data-id='" . $perjalanan->id . "' class='btn btn-success'><i class='fa fa-ticket-alt'></i></a>";
                $btn .= "</div>";
                $check = '';
                $stt = label_green(ucfirst($perjalanan->status_bayar));
            }
            /* if($perjalanan->id_payment != "0") {
                $stmid = $this->midtrans->status($perjalanan->id_payment)->transaction_status;
                $pymid = $this->midtrans->status($perjalanan->id_payment)->payment_type;
                if($stmid == "expire") {
                    $this->batalx($perjalanan->id);
                    $smid = label_green(ucfirst($stmid).' / '.ucfirst($pymid));
                    $btn = label_grey(ucfirst($stmid));
                } else if($stmid == "settlement" || $stmid == "capture") {
                    $this->lunasx($perjalanan->id);
                    $smid = label_green(ucfirst($stmid).' / '.ucfirst($pymid));
                    $stt = label_green('Lunas');
                    $btn = "<a href='#' onClick='popup_print(this)' data-id='".$perjalanan->id."' class='btn btn-success'><i class='fa fa-ticket-alt'></i></a>";
                } else if($stmid == "pending") {
                    $smid = label_grey(ucfirst($stmid).' / '.ucfirst($pymid));
                    $btn = label_grey(ucfirst($stmid));
                } else {
                    $smid = label_green(ucfirst($stmid).' / '.ucfirst($pymid));
                }
                $mid = $perjalanan->id_payment.'<br/>'.$smid;
            } else {
                $mid = "";
            } */
            $mid = $perjalanan->id_payment;
            $row = array();
            $row[] = $check;
            $row[] = $perjalanan->id;
            $row[] = $mid;
            $row[] = $perjalanan->nama_pemesan . "<br/>" . $perjalanan->no_hp;
            if ($perjalanan->id_destination == 2) {
                $jam_berangkatt = explode('.', $waktu_berangkat[1]);
                if ((int)$jam_berangkatt[0] < 9) {
                    $jam_berangkat = '0'.((int)$jam_berangkatt[0] + 1) .'.'. $jam_berangkatt[1];
                } else {
                    $jam_berangkat = (int)$jam_berangkatt[0] + 1 .'.'. $jam_berangkatt[1];
                }
            } else {
                $jam_berangkat = $waktu_berangkat[1];
            }
            // $row[] = $perjalanan->destination . " / Kursi " . $perjalanan->kode_kursi . "<br/><small>" . date_format_id($waktu_berangkat[0]) . " " . $waktu_berangkat[1] . " WIB</small>";
            $row[] = $perjalanan->destination . " / Kursi " . $perjalanan->kode_kursi . "<br/><small>" . date_format_id($waktu_berangkat[0]) . " " . $jam_berangkat . " WIB</small>";
            $row[] = 'Rp. ' . number_format($perjalanan->total_bayar) . "<br/>" . $stt;
            $row[] = 'Rp. ' . number_format($perjalanan->diskon);
            $row[] = $perjalanan->created_by . "<br/><small>" . date_format_id($pesan[0]) . " " . $pesan[1] . " WIB</small>";
            $row[] = $btn;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->perjalanan->count_latest_all(),
            "recordsFiltered" => $this->perjalanan->count_data_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function pilih_kursi()
    {
        if (!empty($this->input->post('tgl_berangkat')) && !empty($this->input->post('jml_penumpang')) && !empty($this->input->post('asal')) && !empty($this->input->post('tujuan')) && !empty($this->input->post('id_des')) && !empty($this->input->post('codeticket'))) {
            $this->session->unset_userdata('info');
            // $this->session->unset_userdata('booking');
            $this->session->unset_userdata('selesai');
            $this->session->unset_userdata('selesai2');
            $this->data['title'] = 'Pilih Kursi';
            $infoKarcis = $this->penjadwalan->get_by(array(
                'id' => $this->input->post('codeticket')
            ));
            $infoKarcis = $infoKarcis[0];
            $infoTravel = $this->travel->get_data_travel($infoKarcis->kode_travel);
            $infoTravel = $infoTravel[0];
            $t0 = $infoKarcis->kode_kursi;
            $t = explode(',', $t0);
            $this->data['jml_penumpang'] = $this->input->post('jml_penumpang');
            // $this->data['jumlah_kursi'] = $infoTravel->jumlah_kursi;
            $jml_kursi         = $this->travel->get_jumlah_kursix($infoKarcis->vehicle_id);
            $this->data['jumlah_kursi'] = $jml_kursi;
            $this->data['ticket'] = $this->input->post('codeticket');
            $this->data['seats'] = $t;
            $this->data['jurusan'] = $this->pool->get_nama($this->input->post('asal')) . '-' . $this->pool->get_nama($this->input->post('tujuan'));
            $this->data['rute'] = $this->destination->get_destination($this->input->post('id_des'));
            $this->data['jam'] = $this->penjadwalan->get_jam($this->input->post('codeticket'));
            if (!empty($this->input->post('ppo'))) {
                if (!empty($this->input->post('tgl_berangkat')) && !empty($this->input->post('id_des2')) && !empty($this->input->post('codeticket2'))) {
                    $infoKarcis2 = $this->penjadwalan->get_by(array(
                        'id' => $this->input->post('codeticket2')
                    ));
                    $infoKarcis2 = $infoKarcis2[0];
                    $infoTravel2 = $this->travel->get_data_travel($infoKarcis2->kode_travel);
                    $infoTravel2 = $infoTravel2[0];
                    $t1 = $infoKarcis2->kode_kursi;
                    $t2 = explode(',', $t1);
                    $this->data['jurusan2'] = $this->pool->get_nama($this->input->post('tujuan')) . '-' . $this->pool->get_nama($this->input->post('asal'));
                    $this->data['rute2'] = $this->destination->get_destination($this->input->post('id_des2'));
                    $this->data['jam2'] = $this->penjadwalan->get_jam($this->input->post('codeticket2'));
                    // $this->data['jumlah_kursi2'] = $infoTravel2->jumlah_kursi;
                    $jml_kursi2         = $this->travel->get_jumlah_kursix($infoKarcis2->vehicle_id);
                    $this->data['jumlah_kursi2'] = $jml_kursi2;
                    $this->data['ticket2'] = $this->input->post('codeticket2');
                    $this->data['seats2'] = $t2;
                    if ((count($t) < $this->input->post('jml_penumpang')) || (count($t2) < $this->input->post('jml_penumpang'))) {
                        $this->session->set_flashdata('message', msg_error('Jumlah kursi di jadwal tersebut kurang dari jumlah penumpang yang berangkat atau kembali. Silakan pilih jadwal atau jam keberangkatan yang lain.'));
                        redirect('rdpl/perjalanan', 'refresh');
                    } else {
                        $data = array(
                            'kode_travel'        => $infoKarcis->kode_travel,
                            'kode_travel2'        => $infoKarcis2->kode_travel,
                            'kode_karcis'        => $this->input->post('codeticket'),
                            'kode_karcis2'        => $this->input->post('codeticket2'),
                            'asal'                => $this->pool->get_nama($this->input->post('asal')),
                            'tujuan'            => $this->pool->get_nama($this->input->post('tujuan')),
                            'id_des'        => $this->input->post('id_des'),
                            'id_des2'        => $this->input->post('id_des2'),
                            'id_asal'                => $this->input->post('asal'),
                            'id_tujuan'            => $this->input->post('tujuan'),
                            'jml_penumpang'        => $this->input->post('jml_penumpang')
                        );
                        $this->session->set_userdata('info', $data);
                        $this->load->view('rdpl/perjalanan/isi_informasi', $this->data);
                    }
                } else {
                    $this->session->set_flashdata('message', msg_error('Isi data kembali dengan lengkap!'));
                    redirect('rdpl/perjalanan', 'refresh');
                }
            } else {
                if (count($t) < $this->input->post('jml_penumpang')) {
                    $this->session->set_flashdata('message', msg_error('Jumlah kursi di jadwal tersebut kurang dari jumlah penumpang yang berangkat. Silakan pilih jadwal atau jam keberangkatan yang lain.'));
                    redirect('rdpl/perjalanan', 'refresh');
                } else {
                    $data = array(
                        'kode_travel'        => $infoKarcis->kode_travel,
                        'kode_karcis'        => $this->input->post('codeticket'),
                        'asal'                => $this->pool->get_nama($this->input->post('asal')),
                        'tujuan'            => $this->pool->get_nama($this->input->post('tujuan')),
                        'id_des'        => $this->input->post('id_des'),
                        'id_asal'                => $this->input->post('asal'),
                        'id_tujuan'            => $this->input->post('tujuan'),
                        'jml_penumpang'        => $this->input->post('jml_penumpang')
                    );
                    $this->session->set_userdata('info', $data);
                    $this->load->view('rdpl/perjalanan/isi_informasi', $this->data);
                }
            }
        } else {
            $this->session->set_flashdata('message', msg_error('Isi data perjalanan dengan lengkap!'));
            redirect('rdpl/perjalanan', 'refresh');
        }
    }
    
    public function pilih_kursi_testing()
    {
        // var_dump($this->input->post());
        // die;
        if (!empty($this->input->post('tgl_berangkat')) && !empty($this->input->post('jml_penumpang')) && !empty($this->input->post('asal')) && !empty($this->input->post('tujuan')) && !empty($this->input->post('id_des')) && !empty($this->input->post('codeticket'))) {
            $this->session->unset_userdata('info');
            // $this->session->unset_userdata('booking');
            $this->session->unset_userdata('selesai');
            $this->session->unset_userdata('selesai2');
            $this->data['title'] = 'Pilih Kursi';
            $infoKarcis = $this->penjadwalan->get_by(array(
                'id' => $this->input->post('codeticket')
            ));
            $infoKarcis = $infoKarcis[0];
            $infoTravel = $this->travel->get_data_travel($infoKarcis->kode_travel);
            $infoTravel = $infoTravel[0];
            $t0 = $infoKarcis->kode_kursi;
            $t = explode(',', $t0);
            $this->data['jml_penumpang'] = $this->input->post('jml_penumpang');
            // $this->data['jumlah_kursi'] = $infoTravel->jumlah_kursi;
            $jml_kursi         = $this->travel->get_jumlah_kursix($infoKarcis->vehicle_id);
            $this->data['jumlah_kursi'] = $jml_kursi;
            $this->data['ticket'] = $this->input->post('codeticket');
            $this->data['seats'] = $t;
            $this->data['jurusan'] = $this->pool->get_nama($this->input->post('asal')) . '-' . $this->pool->get_nama($this->input->post('tujuan'));
            $this->data['asall'] = $this->input->post('asal');
            $this->data['tujuann'] = $this->input->post('tujuan');
            $this->data['rute'] = $this->destination->get_destination($this->input->post('id_des'));
            $this->data['jam'] = $this->penjadwalan->get_jam($this->input->post('codeticket'));
            if (!empty($this->input->post('ppo'))) {
                if (!empty($this->input->post('tgl_kembali')) && !empty($this->input->post('id_des2')) && !empty($this->input->post('codeticket2'))) {
                    $infoKarcis2 = $this->penjadwalan->get_by(array(
                        'id' => $this->input->post('codeticket2')
                    ));
                    $infoKarcis2 = $infoKarcis2[0];
                    $infoTravel2 = $this->travel->get_data_travel($infoKarcis2->kode_travel);
                    $infoTravel2 = $infoTravel2[0];
                    $t1 = $infoKarcis2->kode_kursi;
                    $t2 = explode(',', $t1);
                    $this->data['jurusan2'] = $this->pool->get_nama($this->input->post('tujuan')) . '-' . $this->pool->get_nama($this->input->post('asal'));
                    $this->data['rute2'] = $this->destination->get_destination($this->input->post('id_des2'));
                    $this->data['jam2'] = $this->penjadwalan->get_jam($this->input->post('codeticket2'));
                    // $this->data['jumlah_kursi2'] = $infoTravel2->jumlah_kursi;
                    $jml_kursi2         = $this->travel->get_jumlah_kursix($infoKarcis2->vehicle_id);
                    $this->data['jumlah_kursi2'] = $jml_kursi2;
                    $this->data['ticket2'] = $this->input->post('codeticket2');
                    $this->data['seats2'] = $t2;
                    if ((count($t) < $this->input->post('jml_penumpang')) || (count($t2) < $this->input->post('jml_penumpang'))) {
                        $this->session->set_flashdata('message', msg_error('Jumlah kursi di jadwal tersebut kurang dari jumlah penumpang yang berangkat atau kembali. Silakan pilih jadwal atau jam keberangkatan yang lain.'));
                        redirect('rdpl/perjalanan', 'refresh');
                    } else {
                        $data = array(
                            'kode_travel'        => $infoKarcis->kode_travel,
                            'kode_travel2'        => $infoKarcis2->kode_travel,
                            'kode_karcis'        => $this->input->post('codeticket'),
                            'kode_karcis2'        => $this->input->post('codeticket2'),
                            'asal'                => $this->pool->get_nama($this->input->post('asal')),
                            'tujuan'            => $this->pool->get_nama($this->input->post('tujuan')),
                            'id_des'        => $this->input->post('id_des'),
                            'id_des2'        => $this->input->post('id_des2'),
                            'id_asal'                => $this->input->post('asal'),
                            'id_tujuan'            => $this->input->post('tujuan'),
                            'jml_penumpang'        => $this->input->post('jml_penumpang')
                        );
                        $this->data['kode_travell'] = $infoTravel->kode_travel;
                        $this->data['kode_travell2'] = $infoTravel2->kode_travel;
                        $this->session->set_userdata('info', $data);
                        $this->load->view('rdpl/perjalanan/isi_informasi_testing', $this->data);
                    }
                } else {
                    $this->session->set_flashdata('message', msg_error('Isi data kembali dengan lengkap!'));
                    redirect('rdpl/perjalanan', 'refresh');
                }
            } else {
                if (count($t) < $this->input->post('jml_penumpang')) {
                    $this->session->set_flashdata('message', msg_error('Jumlah kursi di jadwal tersebut kurang dari jumlah penumpang yang berangkat. Silakan pilih jadwal atau jam keberangkatan yang lain.'));
                    redirect('rdpl/perjalanan', 'refresh');
                } else {
                    $data = array(
                        'kode_travel'        => $infoKarcis->kode_travel,
                        'kode_karcis'        => $this->input->post('codeticket'),
                        'asal'                => $this->pool->get_nama($this->input->post('asal')),
                        'tujuan'            => $this->pool->get_nama($this->input->post('tujuan')),
                        'id_des'        => $this->input->post('id_des'),
                        'id_asal'                => $this->input->post('asal'),
                        'id_tujuan'            => $this->input->post('tujuan'),
                        'jml_penumpang'        => $this->input->post('jml_penumpang')
                    );
                    $this->data['kode_travell'] = $infoTravel->kode_travel;
                    $this->session->set_userdata('info', $data);
                    $this->load->view('rdpl/perjalanan/isi_informasi_testing', $this->data);
                }
            }
        } else {
            $this->session->set_flashdata('message', msg_error('Isi data perjalanan dengan lengkap!'));
            redirect('rdpl/perjalanan', 'refresh');
        }
    }

    public function pilih_kursie()
    {
        if (!empty($this->input->post('tgl_berangkat')) && !empty($this->input->post('id_asal')) && !empty($this->input->post('codeticket'))) {
            $this->session->unset_userdata('info');
            // $this->session->unset_userdata('booking');
            $this->session->unset_userdata('selesai');
            $this->session->unset_userdata('selesai2');
            $this->data['title'] = 'Pilih Kursi';
            $infoKarcis = $this->penjadwalan->get_by(array(
                'id' => $this->input->post('codeticket')
            ));
            $infoKarcis = $infoKarcis[0];
            $infoTravel = $this->travel->get_data_travel($infoKarcis->kode_travel);
            $infoTravel = $infoTravel[0];
            $t0 = $infoKarcis->kode_kursi;
            $t = explode(',', $t0);
            $e = $this->perjalanan->get($this->input->post('id_asal'));
            $this->data['jml_penumpang'] = $e->jumlah_kursi;
            $this->data['jumlah_kursi'] = $infoTravel->jumlah_kursi;
            $this->data['ticket'] = $this->input->post('codeticket');
            $this->data['seats'] = $t;
            $this->data['jurusan'] = $e->asal . '-' . $e->tujuan;
            $this->data['rute'] = $e->destination;
            $this->data['jam'] = $this->penjadwalan->get_jam($this->input->post('codeticket'));
            $this->data['nama'] = $e->nama_pemesan;
            $this->data['hp'] = $e->no_hp;
            if (count($t) < $e->jumlah_kursi) {
                $this->session->set_flashdata('message', msg_error('Jumlah kursi di jadwal tersebut kurang dari jumlah penumpang yang berangkat. Silakan pilih jadwal atau jam keberangkatan yang lain.'));
                redirect('rdpl/perjalanan', 'refresh');
            } else {
                $data = array(
                    'kode_travel'        => $infoKarcis->kode_travel,
                    'kode_karcis'        => $this->input->post('codeticket'),
                    'asal'                => $e->asal,
                    'tujuan'            => $e->asal,
                    'id_des'        => $e->id_destination,
                    'id_asal'        => $this->input->post('id_asal'),
                    //'id_asal'				=> $this->input->post('asal'),
                    //'id_tujuan'			=> $this->input->post('tujuan'),
                    'jml_penumpang'        => $e->jumlah_kursi
                );
                $this->session->set_userdata('info', $data);
                $this->load->view('rdpl/perjalanan/isi_informasie', $this->data);
            }
        } else {
            $this->session->set_flashdata('message', msg_error('Isi data perjalanan dengan lengkap!'));
            redirect('rdpl/perjalanan', 'refresh');
        }
    }

    public function checkticket()
    {
        $json = array();
        $tiket = $this->session->userdata('info');
        if ($tiket['kode_karcis'] == $this->input->post('ticket') && $this->session->userdata('loggedin') == TRUE) {
            $newseat = $this->input->post('newseat');
            if (!empty($newseat)) {
                $kursi = array();
                $nw = explode(',', $newseat);
                $rsv = $this->perjalanan->get_result_ticket($tiket['kode_karcis']);
                $newcod = array();
                foreach ($rsv as $cod) {
                    $newcod[] = $cod['kode_kursi'];
                }
                $newcode = implode(",", $newcod);
                $codex = explode(",", $newcode);
                foreach ($nw as $nws) {
                    if (in_array($nws, $codex)) {
                        $kursi[] = "FALSE";
                    } else {
                        $kursi[] = "TRUE";
                    }
                }
                $newseat2 = $this->input->post('newseat2');
                if (!empty($newseat2)) {
                    $nw2 = explode(',', $newseat2);
                    $rsv2 = $this->perjalanan->get_result_ticket($tiket['kode_karcis2']);
                    $newcod2 = array();
                    foreach ($rsv2 as $cod2) {
                        $newcod2[] = $cod2['kode_kursi'];
                    }
                    $newcode2 = implode(",", $newcod2);
                    $codex2 = explode(",", $newcode2);
                    foreach ($nw2 as $nws2) {
                        if (in_array($nws2, $codex2)) {
                            $kursi[] = "FALSE";
                        } else {
                            $kursi[] = "TRUE";
                        }
                    }
                }
                if (in_array("FALSE", $kursi)) {
                    $json['msg'] = "Opps!";
                    foreach ($nw as $nws) {
                        if (in_array($nws, $codex)) {
                            $json['msg'] .= "Kursi " . $nws . " sudah tidak tersedia!";
                        } else {
                            $json['msg'] .= "Kursi " . $nws . " masih tersedia.";
                        }
                    }
                    if (!empty($newseat2)) {
                        foreach ($nw2 as $nws2) {
                            if (in_array($nws2, $codex2)) {
                                $json['msg'] .= "Kursi " . $nws2 . " sudah tidak tersedia!";
                            } else {
                                $json['msg'] .= "Kursi " . $nws2 . " masih tersedia.";
                            }
                        }
                    }
                    $json['msg'] .= "Silakan pilih kursi lainnya...";
                } else {
                    if ($tiket['jml_penumpang'] != count($nw)) {
                        $json['status'] = "kosong";
                        $json['msg'] = "Silakan pilih kursi Anda dengan lengkap...";
                    } else {
                        $destination = $this->destination->get_by(array(
                            'id'    =>    $tiket['id_des']
                        ));
                        $destination = $destination[0];
                        $infoKarcis = $this->penjadwalan->get_by(array(
                            'id' => $tiket['kode_karcis']
                        ));
                        $infoKarcis = $infoKarcis[0];
                        $tb = strtotime($infoKarcis->tgl_berangkat);
                        $sd = strtotime($destination->start_date);
                        $ed = strtotime($destination->end_date);
                        if (!empty($tiket['id_des2'])) {
                            $destination2 = $this->destination->get_by(array(
                                'id'    =>    $tiket['id_des2']
                            ));
                            $destination2 = $destination2[0];
                            $infoKarcis2 = $this->penjadwalan->get_by(array(
                                'id' => $tiket['kode_karcis2']
                            ));
                            $infoKarcis2 = $infoKarcis2[0];
                            $tp = strtotime($infoKarcis2->tgl_berangkat);
                            $tb = strtotime($infoKarcis2->tgl_berangkat);
                            $sd = strtotime($destination2->start_date);
                            $ed = strtotime($destination2->end_date);
                            if ($tp < $sd || $tp > $ed) {
                                $hrg2 = $destination2->harga;
                            } elseif ($tp >= $sd || $tp <= $ed) {
                                $hrg2 = $destination2->harga_baru;
                            }
                            if ($tb < $sd || $tb > $ed) {
                                $hrg = $destination->harga;
                            } elseif ($tb >= $sd || $tb <= $ed) {
                                $hrg = $destination->harga_baru;
                            }
                            $data = array(
                                'kode_travel'        =>  $tiket['kode_travel'],
                                'kode_travel2'        =>  $tiket['kode_travel2'],
                                'kode_karcis'        =>  $tiket['kode_karcis'],
                                'kode_karcis2'        =>  $tiket['kode_karcis2'],
                                'nama_pemesan'        =>    $this->input->post('nama'),
                                'asal'                =>    $tiket['asal'],
                                'tujuan'            =>    $tiket['tujuan'],
                                'id_asal'            =>    $tiket['id_asal'],
                                'id_tujuan'            =>    $tiket['id_tujuan'],
                                'waktu_berangkat'    =>     $infoKarcis->tgl_berangkat . ' ' . $infoKarcis->jam_berangkat,
                                'waktu_kembali'        =>     $infoKarcis2->tgl_berangkat . ' ' . $infoKarcis2->jam_berangkat,
                                'no_hp'                =>     $this->input->post('hp'),
                                'jml_penumpang'        =>  $tiket['jml_penumpang'],
                                'nama_penumpang'    =>  $this->input->post('nama'),
                                'kode_kursi'        =>    $newseat,
                                'kode_kursi2'        =>    $newseat2,
                                'harga_tiket'        =>    $hrg,
                                'harga_tiket2'        =>    $hrg2,
                                'destination'        =>    $destination->destination,
                                'destination2'        =>    $destination2->destination,
                                'id_destination'    =>    $tiket['id_des'],
                                'id_destination2'    =>    $tiket['id_des2'],
                            );

                            $this->session->set_userdata('booking', $data);
                            $json['status'] = "suksess";
                        } else {
                            if ($tb < $sd || $tb > $ed) {
                                $hrg = $destination->harga;
                            } elseif ($tb >= $sd || $tb <= $ed) {
                                $hrg = $destination->harga_baru;
                            }
                            $data = array(
                                'kode_travel'        =>  $tiket['kode_travel'],
                                'kode_karcis'        =>  $tiket['kode_karcis'],
                                'nama_pemesan'        =>    $this->input->post('nama'),
                                'asal'                =>    $tiket['asal'],
                                'tujuan'            =>    $tiket['tujuan'],
                                'id_asal'                =>    $tiket['id_asal'],
                                'id_tujuan'            =>    $tiket['id_tujuan'],
                                'waktu_berangkat'    =>     $infoKarcis->tgl_berangkat . ' ' . $infoKarcis->jam_berangkat,
                                'no_hp'                =>     $this->input->post('hp'),
                                'jml_penumpang'        =>  $tiket['jml_penumpang'],
                                'nama_penumpang'    =>  $this->input->post('nama'),
                                'kode_kursi'        =>    $newseat,
                                'harga_tiket'        =>    $hrg,
                                'destination'        =>    $destination->destination,
                                'id_destination'    =>    $tiket['id_des'],
                            );
                            $this->session->set_userdata('booking', $data);
                            $json['status'] = "sukses";
                        }
                    }
                }
            } else {
                $json['status'] = "kosong";
                $json['msg'] = "Silakan pilih kursi Anda dengan lengkap...";
            }
        } else {
            $json['status'] = "sesi";
            $json['msg'] = "Sesi Anda telah berubah, silakan pilih jadwal lainnya...";
        }
        $this->output->set_content_type('application/json');
        echo json_encode($json);
    }
    
    public function checkticket_testing()
    {
        $json = array();
        $tiket = $this->session->userdata('info');
        if ($tiket['kode_karcis'] == $this->input->post('ticket') && $this->session->userdata('loggedin') == TRUE) {
            $newseat = $this->input->post('newseat');
            if (!empty($newseat)) {
                $kursi = array();
                $nw = explode(',', $newseat);
                $rsv = $this->perjalanan->get_result_ticket($tiket['kode_karcis']);
                $newcod = array();
                foreach ($rsv as $cod) {
                    $newcod[] = $cod['kode_kursi'];
                }
                $newcode = implode(",", $newcod);
                $codex = explode(",", $newcode);
                foreach ($nw as $nws) {
                    if (in_array($nws, $codex)) {
                        $kursi[] = "FALSE";
                    } else {
                        $kursi[] = "TRUE";
                    }
                }
                $newseat2 = $this->input->post('newseat2');
                if (!empty($newseat2)) {
                    $nw2 = explode(',', $newseat2);
                    $rsv2 = $this->perjalanan->get_result_ticket($tiket['kode_karcis2']);
                    $newcod2 = array();
                    foreach ($rsv2 as $cod2) {
                        $newcod2[] = $cod2['kode_kursi'];
                    }
                    $newcode2 = implode(",", $newcod2);
                    $codex2 = explode(",", $newcode2);
                    foreach ($nw2 as $nws2) {
                        if (in_array($nws2, $codex2)) {
                            $kursi[] = "FALSE";
                        } else {
                            $kursi[] = "TRUE";
                        }
                    }
                }
                if (in_array("FALSE", $kursi)) {
                    $json['msg'] = "Opps!";
                    foreach ($nw as $nws) {
                        if (in_array($nws, $codex)) {
                            $json['msg'] .= "Kursi " . $nws . " sudah tidak tersedia!";
                        } else {
                            $json['msg'] .= "Kursi " . $nws . " masih tersedia.";
                        }
                    }
                    if (!empty($newseat2)) {
                        foreach ($nw2 as $nws2) {
                            if (in_array($nws2, $codex2)) {
                                $json['msg'] .= "Kursi " . $nws2 . " sudah tidak tersedia!";
                            } else {
                                $json['msg'] .= "Kursi " . $nws2 . " masih tersedia.";
                            }
                        }
                    }
                    $json['msg'] .= "Silakan pilih kursi lainnya...";
                } else {
                    if ($tiket['jml_penumpang'] != count($nw)) {
                        $json['status'] = "kosong";
                        $json['msg'] = "Silakan pilih kursi Anda dengan lengkap...";
                    } else {
                        $destination = $this->destination->get_by(array(
                            'id'    =>    $tiket['id_des']
                        ));
                        $destination = $destination[0];
                        $infoKarcis = $this->penjadwalan->get_by(array(
                            'id' => $tiket['kode_karcis']
                        ));
                        $infoKarcis = $infoKarcis[0];
                        $tb = strtotime($infoKarcis->tgl_berangkat);
                        $sd = strtotime($destination->start_date);
                        $ed = strtotime($destination->end_date);
                        if (!empty($tiket['id_des2'])) {
                            $destination2 = $this->destination->get_by(array(
                                'id'    =>    $tiket['id_des2']
                            ));
                            $destination2 = $destination2[0];
                            $infoKarcis2 = $this->penjadwalan->get_by(array(
                                'id' => $tiket['kode_karcis2']
                            ));
                            $infoKarcis2 = $infoKarcis2[0];
                            $tp = strtotime($infoKarcis2->tgl_berangkat);
                            $tb = strtotime($infoKarcis2->tgl_berangkat);
                            $sd = strtotime($destination2->start_date);
                            $ed = strtotime($destination2->end_date);
                            if ($tp < $sd || $tp > $ed) {
                                $hrg2 = $destination2->harga;
                            } elseif ($tp >= $sd || $tp <= $ed) {
                                $hrg2 = $destination2->harga_baru;
                            }
                            if ($tb < $sd || $tb > $ed) {
                                $hrg = $destination->harga;
                            } elseif ($tb >= $sd || $tb <= $ed) {
                                $hrg = $destination->harga_baru;
                            }
                            $data = array(
                                'kode_travel'        =>  $tiket['kode_travel'],
                                'kode_travel2'        =>  $tiket['kode_travel2'],
                                'kode_karcis'        =>  $tiket['kode_karcis'],
                                'kode_karcis2'        =>  $tiket['kode_karcis2'],
                                'nama_pemesan'        =>    $this->input->post('nama'),
                                'asal'                =>    $tiket['asal'],
                                'tujuan'            =>    $tiket['tujuan'],
                                'id_asal'            =>    $tiket['id_asal'],
                                'id_tujuan'            =>    $tiket['id_tujuan'],
                                'waktu_berangkat'    =>     $infoKarcis->tgl_berangkat . ' ' . $infoKarcis->jam_berangkat,
                                'waktu_kembali'        =>     $infoKarcis2->tgl_berangkat . ' ' . $infoKarcis2->jam_berangkat,
                                'no_hp'                =>     $this->input->post('hp'),
                                'jml_penumpang'        =>  $tiket['jml_penumpang'],
                                'nama_penumpang'    =>  $this->input->post('nama'),
                                'kode_kursi'        =>    $newseat,
                                'kode_kursi2'        =>    $newseat2,
                                'harga_tiket'        =>    $hrg,
                                'harga_tiket2'        =>    $hrg2,
                                'destination'        =>    $destination->destination,
                                'destination2'        =>    $destination2->destination,
                                'id_destination'    =>    $tiket['id_des'],
                                'id_destination2'    =>    $tiket['id_des2'],
                            );

                            $this->session->set_userdata('booking', $data);
                            // var_dump($this->session->userdata('booking'));
                            // die;
                            $json['status'] = "sukses";
                        } else {
                            if ($tb < $sd || $tb > $ed) {
                                $hrg = $destination->harga;
                            } elseif ($tb >= $sd || $tb <= $ed) {
                                $hrg = $destination->harga_baru;
                            }
                            $data = array(
                                'kode_travel'        =>  $tiket['kode_travel'],
                                'kode_karcis'        =>  $tiket['kode_karcis'],
                                'nama_pemesan'        =>    $this->input->post('nama'),
                                'asal'                =>    $tiket['asal'],
                                'tujuan'            =>    $tiket['tujuan'],
                                'id_asal'                =>    $tiket['id_asal'],
                                'id_tujuan'            =>    $tiket['id_tujuan'],
                                'waktu_berangkat'    =>     $infoKarcis->tgl_berangkat . ' ' . $infoKarcis->jam_berangkat,
                                'no_hp'                =>     $this->input->post('hp'),
                                'jml_penumpang'        =>  $tiket['jml_penumpang'],
                                'nama_penumpang'    =>  $this->input->post('nama'),
                                'kode_kursi'        =>    $newseat,
                                'harga_tiket'        =>    $hrg,
                                'destination'        =>    $destination->destination,
                                'id_destination'    =>    $tiket['id_des'],
                            );
                            $this->session->set_userdata('booking', $data);
                            $json['status'] = "sukses";
                        }
                    }
                }
            } else {
                $json['status'] = "kosong";
                $json['msg'] = "Silakan pilih kursi Anda dengan lengkap...";
            }
        } else {
            $json['status'] = "sesi";
            $json['msg'] = "Sesi Anda telah berubah, silakan pilih jadwal lainnya...";
        }
        $this->output->set_content_type('application/json');
        $this->session->set_userdata('booking', $data);
        echo json_encode($json);
    }

    public function checktickete()
    {
        $json = array();
        $tiket = $this->session->userdata('info');
        if ($tiket['kode_karcis'] == $this->input->post('ticket') && $this->session->userdata('loggedin') == TRUE) {
            $newseat = $this->input->post('newseat');
            if (!empty($newseat)) {
                $kursi = array();
                $nw = explode(',', $newseat);
                $rsv = $this->perjalanan->get_result_ticket($tiket['kode_karcis']);
                $newcod = array();
                foreach ($rsv as $cod) {
                    $newcod[] = $cod['kode_kursi'];
                }
                $newcode = implode(",", $newcod);
                $codex = explode(",", $newcode);
                foreach ($nw as $nws) {
                    if (in_array($nws, $codex)) {
                        $kursi[] = "FALSE";
                    } else {
                        $kursi[] = "TRUE";
                    }
                }
                if (in_array("FALSE", $kursi)) {
                    $json['msg'] = "Opps!";
                    foreach ($nw as $nws) {
                        if (in_array($nws, $codex)) {
                            $json['msg'] .= "Kursi " . $nws . " sudah tidak tersedia!";
                        } else {
                            $json['msg'] .= "Kursi " . $nws . " masih tersedia.";
                        }
                    }
                    $json['msg'] .= "Silakan pilih kursi lainnya...";
                } else {
                    if ($tiket['jml_penumpang'] != count($nw)) {
                        $json['status'] = "kosong";
                        $json['msg'] = "Silakan pilih kursi Anda dengan lengkap...";
                    } else {
                        $destination = $this->destination->get_by(array(
                            'id'    =>    $tiket['id_des']
                        ));
                        $destination = $destination[0];
                        $infoKarcis = $this->penjadwalan->get_by(array(
                            'id' => $tiket['kode_karcis']
                        ));
                        $infoKarcis = $infoKarcis[0];
                        $tb = strtotime($infoKarcis->tgl_berangkat);
                        $sd = strtotime($destination->start_date);
                        $ed = strtotime($destination->end_date);
                        if ($tb < $sd || $tb > $ed) {
                            $hrg = $destination->harga;
                        } elseif ($tb >= $sd || $tb <= $ed) {
                            $hrg = $destination->harga_baru;
                        }
                        $data = array(
                            'kode_travel'        =>  $tiket['kode_travel'],
                            'kode_karcis'        =>  $tiket['kode_karcis'],
                            'nama_pemesan'        =>    $this->input->post('nama'),
                            'asal'                =>    $tiket['asal'],
                            'tujuan'            =>    $tiket['tujuan'],
                            'id_asal'        => $tiket['id_asal'],
                            //'id_asal'				=>	$tiket['id_asal'],
                            //'id_tujuan'			=>	$tiket['id_tujuan'],
                            'waktu_berangkat'    =>     $infoKarcis->tgl_berangkat . ' ' . $infoKarcis->jam_berangkat,
                            'no_hp'                =>     $this->input->post('hp'),
                            'jml_penumpang'        =>  $tiket['jml_penumpang'],
                            'nama_penumpang'    =>  $this->input->post('nama'),
                            'kode_kursi'        =>    $newseat,
                            'harga_tiket'        =>    $hrg,
                            'destination'        =>    $destination->destination,
                            'id_destination'    =>    $tiket['id_des'],
                        );
                        $this->session->set_userdata('booking', $data);
                        $json['status'] = "sukses";
                    }
                }
            } else {
                $json['status'] = "kosong";
                $json['msg'] = "Silakan pilih kursi Anda dengan lengkap...";
            }
        } else {
            $json['status'] = "sesi";
            $json['msg'] = "Sesi Anda telah berubah, silakan pilih jadwal lainnya...";
        }
        $this->output->set_content_type('application/json');
        echo json_encode($json);
    }

    public function booking()
    {
        // if ($this->session->userdata('id') == 57 || $this->session->userdata('id') == '57') {
        //     var_dump($this->session->userdata('booking'));
        //     die;
        // }
        $this->data['title'] = 'Data Perjalanan Anda';
        $this->load->view('rdpl/perjalanan/booking', $this->data);
    }
    
    public function booking_testing()
    {
        // if ($this->session->userdata('id') == 57 || $this->session->userdata('id') == '57') {
        //     var_dump($this->session->userdata('booking'));
        //     die;
        // }
        $this->data['title'] = 'Data Perjalanan Anda';
        $this->load->view('rdpl/perjalanan/booking_testing', $this->data);
    }

    public function bookinge()
    {
        $this->data['title'] = 'Data Perjalanan Anda';
        $this->load->view('rdpl/perjalanan/bookinge', $this->data);
    }

    public function selesai()
    {
        $json = array();
        if (!empty($this->input->post('pesan_via'))) {
            if ($this->session->userdata('group_id') == 1) {
                $pool_id = 3;
            } else {
                $pool_id = $this->session->userdata('pool_id');
            }
            $booking = $this->session->userdata('booking');
            $kursi = array();
            $nw = explode(',', $booking['kode_kursi']);
            $rsv = $this->perjalanan->get_result_ticket($booking['kode_karcis']);
            $newcod = array();
            foreach ($rsv as $cod) {
                $newcod[] = $cod['kode_kursi'];
            }
            $newcode = implode(",", $newcod);
            $codex = explode(",", $newcode);
            foreach ($nw as $nws) {
                if (in_array($nws, $codex)) {
                    $kursi[] = "FALSE";
                } else {
                    $kursi[] = "TRUE";
                }
            }
            if (!empty($booking['kode_kursi2'])) {
                $nw2 = explode(',', $booking['kode_kursi2']);
                $rsv2 = $this->perjalanan->get_result_ticket($booking['kode_karcis2']);
                $newcod2 = array();
                foreach ($rsv2 as $cod2) {
                    $newcod2[] = $cod2['kode_kursi'];
                }
                $newcode2 = implode(",", $newcod2);
                $codex2 = explode(",", $newcode2);
                foreach ($nw2 as $nws2) {
                    if (in_array($nws2, $codex2)) {
                        $kursi[] = "FALSE";
                    } else {
                        $kursi[] = "TRUE";
                    }
                }
            }
            if (in_array("FALSE", $kursi)) {
                $json['msg'] = "Opps!";
                foreach ($nw as $nws) {
                    if (in_array($nws, $codex)) {
                        $json['msg'] .= "Kursi " . $nws . " sudah tidak tersedia!";
                    } else {
                        $json['msg'] .= "Kursi " . $nws . " masih tersedia.";
                    }
                }
                if (!empty($booking['kode_kursi2'])) {
                    foreach ($nw2 as $nws2) {
                        if (in_array($nws2, $codex2)) {
                            $json['msg'] .= "Kursi " . $nws2 . " sudah tidak tersedia!";
                        } else {
                            $json['msg'] .= "Kursi " . $nws2 . " masih tersedia.";
                        }
                    }
                }
                $json['msg'] .= "Silakan pilih kursi lainnya...";
                $json['status'] = "gagal";
            } else {
                $json['msg'] .= "Silakan pilih kursi lainnya...";
                $json['status'] = "sukses";
            }
        } else {
            $json['msg'] .= "Silakan lengkapi form...";
            $json['status'] = "gagal";
        }
        $this->output->set_content_type('application/json');
        echo json_encode($json);
    }
    
    public function selesai_testing()
    {
        $json = array();
        if (!empty($this->input->post('pesan_via'))) {
            if ($this->session->userdata('group_id') == 1) {
                $pool_id = 3;
            } else {
                $pool_id = $this->session->userdata('pool_id');
            }
            $booking = $this->session->userdata('booking');
            $kursi = array();
            $nw = explode(',', $booking['kode_kursi']);
            $rsv = $this->perjalanan->get_result_ticket($booking['kode_karcis']);
            $newcod = array();
            foreach ($rsv as $cod) {
                $newcod[] = $cod['kode_kursi'];
            }
            $newcode = implode(",", $newcod);
            $codex = explode(",", $newcode);
            foreach ($nw as $nws) {
                if (in_array($nws, $codex)) {
                    $kursi[] = "FALSE";
                } else {
                    $kursi[] = "TRUE";
                }
            }
            if (!empty($booking['kode_kursi2'])) {
                $nw2 = explode(',', $booking['kode_kursi2']);
                $rsv2 = $this->perjalanan->get_result_ticket($booking['kode_karcis2']);
                $newcod2 = array();
                foreach ($rsv2 as $cod2) {
                    $newcod2[] = $cod2['kode_kursi'];
                }
                $newcode2 = implode(",", $newcod2);
                $codex2 = explode(",", $newcode2);
                foreach ($nw2 as $nws2) {
                    if (in_array($nws2, $codex2)) {
                        $kursi[] = "FALSE";
                    } else {
                        $kursi[] = "TRUE";
                    }
                }
            }
            if (in_array("FALSE", $kursi)) {
                $json['msg'] = "Opps!";
                foreach ($nw as $nws) {
                    if (in_array($nws, $codex)) {
                        $json['msg'] .= "Kursi " . $nws . " sudah tidak tersedia!";
                    } else {
                        $json['msg'] .= "Kursi " . $nws . " masih tersedia.";
                    }
                }
                if (!empty($booking['kode_kursi2'])) {
                    foreach ($nw2 as $nws2) {
                        if (in_array($nws2, $codex2)) {
                            $json['msg'] .= "Kursi " . $nws2 . " sudah tidak tersedia!";
                        } else {
                            $json['msg'] .= "Kursi " . $nws2 . " masih tersedia.";
                        }
                    }
                }
                $json['msg'] .= "Silakan pilih kursi lainnya...";
                $json['status'] = "gagal";
            } else {
                $json['msg'] .= "Silakan pilih kursi lainnya...";
                $json['status'] = "sukses";
            }
        } else {
            $json['msg'] .= "Silakan lengkapi form...";
            $json['status'] = "gagal";
        }
        $this->output->set_content_type('application/json');
        echo json_encode($json);
    }

    public function selesaie()
    {
        $json = array();
        if ($this->session->userdata('group_id') == 1) {
            $pool_id = 3;
        } else {
            $pool_id = $this->session->userdata('pool_id');
        }
        $booking = $this->session->userdata('booking');
        $kursi = array();
        $nw = explode(',', $booking['kode_kursi']);
        $rsv = $this->perjalanan->get_result_ticket($booking['kode_karcis']);
        $newcod = array();
        foreach ($rsv as $cod) {
            $newcod[] = $cod['kode_kursi'];
        }
        $newcode = implode(",", $newcod);
        $codex = explode(",", $newcode);
        foreach ($nw as $nws) {
            if (in_array($nws, $codex)) {
                $kursi[] = "FALSE";
            } else {
                $kursi[] = "TRUE";
            }
        }
        if (in_array("FALSE", $kursi)) {
            $json['msg'] = "Opps!";
            foreach ($nw as $nws) {
                if (in_array($nws, $codex)) {
                    $json['msg'] .= "Kursi " . $nws . " sudah tidak tersedia!";
                } else {
                    $json['msg'] .= "Kursi " . $nws . " masih tersedia.";
                }
            }
            $json['msg'] .= "Silakan pilih kursi lainnya...";
            $json['status'] = "gagal";
        } else {
            $json['msg'] .= "Silakan pilih kursi lainnya...";
            $json['status'] = "sukses";
        }
        $this->output->set_content_type('application/json');
        echo json_encode($json);
    }

    public function goticket()
    {
        $json = array();
        if ($this->session->userdata('group_id') == 1) {
            $pool_id = 3;
        } else {
            $pool_id = $this->session->userdata('pool_id');
        }
        $booking = $this->session->userdata('booking');
        if (!empty($booking['kode_travel2'])) {
            $total_bayar2 = $booking['harga_tiket2'] * $booking['jml_penumpang'];
            $pemesanan2 = array(
                // kode_travel mungkin nanti bisa dihapus saja
                'kode_travel'        => $booking['kode_travel2'],
                // id_destination mungkin nanti bisa dihapus saja
                'id_destination'    => $booking['id_destination2'],
                'pool_id'            => $pool_id,
                //'pool_id'			=> $booking['id_tujuan'],
                'kode_karcis'        => $booking['kode_karcis2'],
                'no_hp'                => $booking['no_hp'],
                'nama_pemesan'        => $booking['nama_pemesan'],
                'nama_penumpang'    => $booking['nama_penumpang'],
                'kode_kursi'        => $booking['kode_kursi2'],
                'asal'                 => $booking['tujuan'],
                'tujuan'             => $booking['asal'],
                'destination'        => $booking['destination2'],
                'waktu_berangkat'     => $booking['waktu_kembali'],
                'harga_tiket'        => $booking['harga_tiket2'],
                'total_bayar'         => $total_bayar2,
                'jumlah_kursi'         => $booking['jml_penumpang'],
                'pesan_via'            => $this->input->post('pesan_via'),
                //'pindahan' 		=> '0',
                'created'             => date('Y-m-d H:i:s'),
                'updated'             => date('Y-m-d H:i:s'),
                'created_by'         => $this->session->userdata['username'],
                'updated_by'         => $this->session->userdata['username']
            );
            $id = $this->perjalanan->save($pemesanan2);
            if ($id) {
                $datay = array(
                    'id'        =>  $id
                );
                $this->session->set_userdata('selesai2', $datay);
                $dataKarcis2 = $this->penjadwalan->get_tiket_by_kode($booking['kode_karcis2']);
                $jumlah_kursi_tersedia2 = $dataKarcis2[0]->jumlah_kursi;
                $kode_kursi_tersedia2 = $dataKarcis2[0]->kode_kursi;
                $kode_kursi_tersedia2 = explode(',', $kode_kursi_tersedia2);
                $kode_kursi_dipesan2 = explode(',', $booking['kode_kursi2']);
                $sisa_kursi2 = array_diff($kode_kursi_tersedia2, $kode_kursi_dipesan2);
                $sisa_kursi2 = implode(',', $sisa_kursi2);
                $data2 = array(
                    'jumlah_kursi'    => $jumlah_kursi_tersedia2 - $booking['jml_penumpang'],
                    'kode_kursi'    => $sisa_kursi2
                );
                $this->penjadwalan->update_karcis_by_kode_karcis($data2, $booking['kode_karcis2']);
            }
        }
        $total_bayar = $booking['harga_tiket'] * $booking['jml_penumpang'];
        $pemesanan = array(
            // kode_travel mungkin nanti bisa dihapus saja
            'kode_travel'        => $booking['kode_travel'],
            // id_destination mungkin nanti bisa dihapus saja
            'id_destination'    => $booking['id_destination'],
            'pool_id'            => $pool_id,
            //'pool_id'			=> $booking['id_asal'],
            'kode_karcis'        => $booking['kode_karcis'],
            'no_hp'                => $booking['no_hp'],
            'nama_pemesan'        => $booking['nama_pemesan'],
            'nama_penumpang'    => $booking['nama_penumpang'],
            'kode_kursi'        => $booking['kode_kursi'],
            'asal'                 => $booking['asal'],
            'tujuan'             => $booking['tujuan'],
            'destination'        => $booking['destination'],
            'waktu_berangkat'     => $booking['waktu_berangkat'],
            'harga_tiket'        => $booking['harga_tiket'],
            'total_bayar'         => $total_bayar,
            'jumlah_kursi'         => $booking['jml_penumpang'],
            /* 'pindahan' 		=> '0',
            'id_payment' 		=> '0',
            'notif_payment' 		=> '0',
            'bayar_via' 		=> '',
            'status_bayar' 		=> 'belum lunas',
            'biaya' 		=> '0',
            'diskon' 		=> '0',
            'cetak' 		=> '0', */
            'pesan_via'            => $this->input->post('pesan_via'),
            'created'             => date('Y-m-d H:i:s'),
            'updated'             => date('Y-m-d H:i:s'),
            'created_by'         => $this->session->userdata['username'],
            'updated_by'         => $this->session->userdata['username']
        );
        //$this->db->insert('st_data_perjalanan', $pemesanan);
        //$id = $this->db->insert_id();
        $id = $this->perjalanan->save($pemesanan);
        if ($id) {
            $datax = array(
                'id'        =>  $id
            );
            $this->session->set_userdata('selesai', $datax);
            $dataKarcis = $this->penjadwalan->get_tiket_by_kode($booking['kode_karcis']);
            $jumlah_kursi_tersedia = $dataKarcis[0]->jumlah_kursi;
            $kode_kursi_tersedia = $dataKarcis[0]->kode_kursi;
            $kode_kursi_tersedia = explode(',', $kode_kursi_tersedia);
            $kode_kursi_dipesan = explode(',', $booking['kode_kursi']);
            $sisa_kursi = array_diff($kode_kursi_tersedia, $kode_kursi_dipesan);
            $sisa_kursi = implode(',', $sisa_kursi);
            $data = array(
                'jumlah_kursi'    => $jumlah_kursi_tersedia - $booking['jml_penumpang'],
                'kode_kursi'    => $sisa_kursi
            );
            $this->penjadwalan->update_karcis_by_kode_karcis($data, $booking['kode_karcis']);
            $json['msg'] = "Pesanan Anda sudah selesai, silakan kirim SMS ke penumpang...";
            $json['status'] = "sukses";
            $json['id'] = $id;
        } else {
            $json['msg'] = "Sesuatu telah gagal diproses..." . $pool_id;
            $json['status'] = "gagal";
        }
        $this->output->set_content_type('application/json');
        echo json_encode($json);
    }
    
    public function goticket_testing()
    {
        $json = array();
        if ($this->session->userdata('group_id') == 1) {
            $pool_id = 3;
        } else {
            $pool_id = $this->session->userdata('pool_id');
        }
        $booking = $this->session->userdata('booking');
        if (!empty($booking['kode_travel2'])) {
            $total_bayar2 = $booking['harga_tiket2'] * $booking['jml_penumpang'];
            $pemesanan2 = array(
                // kode_travel mungkin nanti bisa dihapus saja
                'kode_travel'        => $booking['kode_travel2'],
                // id_destination mungkin nanti bisa dihapus saja
                'id_destination'    => $booking['id_destination2'],
                'pool_id'            => $pool_id,
                //'pool_id'			=> $booking['id_tujuan'],
                'kode_karcis'        => $booking['kode_karcis2'],
                'no_hp'                => $booking['no_hp'],
                'nama_pemesan'        => $booking['nama_pemesan'],
                'nama_penumpang'    => $booking['nama_penumpang'],
                'kode_kursi'        => $booking['kode_kursi2'],
                'asal'                 => $booking['tujuan'],
                'tujuan'             => $booking['asal'],
                'destination'        => $booking['destination2'],
                'waktu_berangkat'     => $booking['waktu_kembali'],
                'harga_tiket'        => $booking['harga_tiket2'],
                'total_bayar'         => $total_bayar2,
                'jumlah_kursi'         => $booking['jml_penumpang'],
                'pesan_via'            => $this->input->post('pesan_via'),
                //'pindahan' 		=> '0',
                'created'             => date('Y-m-d H:i:s'),
                'updated'             => date('Y-m-d H:i:s'),
                'created_by'         => $this->session->userdata['username'],
                'updated_by'         => $this->session->userdata['username']
            );
            $id = $this->perjalanan->save($pemesanan2);
            if ($id) {
                $datay = array(
                    'id'        =>  $id
                );
                $this->session->set_userdata('selesai2', $datay);
                $dataKarcis2 = $this->penjadwalan->get_tiket_by_kode($booking['kode_karcis2']);
                $jumlah_kursi_tersedia2 = $dataKarcis2[0]->jumlah_kursi;
                $kode_kursi_tersedia2 = $dataKarcis2[0]->kode_kursi;
                $kode_kursi_tersedia2 = explode(',', $kode_kursi_tersedia2);
                $kode_kursi_dipesan2 = explode(',', $booking['kode_kursi2']);
                $sisa_kursi2 = array_diff($kode_kursi_tersedia2, $kode_kursi_dipesan2);
                $sisa_kursi2 = implode(',', $sisa_kursi2);
                $data2 = array(
                    'jumlah_kursi'    => $jumlah_kursi_tersedia2 - $booking['jml_penumpang'],
                    'kode_kursi'    => $sisa_kursi2
                );
                $this->penjadwalan->update_karcis_by_kode_karcis($data2, $booking['kode_karcis2']);
            }
        }
        $total_bayar = $booking['harga_tiket'] * $booking['jml_penumpang'];
        $pemesanan = array(
            // kode_travel mungkin nanti bisa dihapus saja
            'kode_travel'        => $booking['kode_travel'],
            // id_destination mungkin nanti bisa dihapus saja
            'id_destination'    => $booking['id_destination'],
            'pool_id'            => $pool_id,
            //'pool_id'			=> $booking['id_asal'],
            'kode_karcis'        => $booking['kode_karcis'],
            'no_hp'                => $booking['no_hp'],
            'nama_pemesan'        => $booking['nama_pemesan'],
            'nama_penumpang'    => $booking['nama_penumpang'],
            'kode_kursi'        => $booking['kode_kursi'],
            'asal'                 => $booking['asal'],
            'tujuan'             => $booking['tujuan'],
            'destination'        => $booking['destination'],
            'waktu_berangkat'     => $booking['waktu_berangkat'],
            'harga_tiket'        => $booking['harga_tiket'],
            'total_bayar'         => $total_bayar,
            'jumlah_kursi'         => $booking['jml_penumpang'],
            /* 'pindahan' 		=> '0',
            'id_payment' 		=> '0',
            'notif_payment' 		=> '0',
            'bayar_via' 		=> '',
            'status_bayar' 		=> 'belum lunas',
            'biaya' 		=> '0',
            'diskon' 		=> '0',
            'cetak' 		=> '0', */
            'pesan_via'            => $this->input->post('pesan_via'),
            'created'             => date('Y-m-d H:i:s'),
            'updated'             => date('Y-m-d H:i:s'),
            'created_by'         => $this->session->userdata['username'],
            'updated_by'         => $this->session->userdata['username']
        );
        //$this->db->insert('st_data_perjalanan', $pemesanan);
        //$id = $this->db->insert_id();
        $id = $this->perjalanan->save($pemesanan);
        if ($id) {
            $datax = array(
                'id'        =>  $id
            );
            $this->session->set_userdata('selesai', $datax);
            $dataKarcis = $this->penjadwalan->get_tiket_by_kode($booking['kode_karcis']);
            $jumlah_kursi_tersedia = $dataKarcis[0]->jumlah_kursi;
            $kode_kursi_tersedia = $dataKarcis[0]->kode_kursi;
            $kode_kursi_tersedia = explode(',', $kode_kursi_tersedia);
            $kode_kursi_dipesan = explode(',', $booking['kode_kursi']);
            $sisa_kursi = array_diff($kode_kursi_tersedia, $kode_kursi_dipesan);
            $sisa_kursi = implode(',', $sisa_kursi);
            $data = array(
                'jumlah_kursi'    => $jumlah_kursi_tersedia - $booking['jml_penumpang'],
                'kode_kursi'    => $sisa_kursi
            );
            $this->penjadwalan->update_karcis_by_kode_karcis($data, $booking['kode_karcis']);
            $json['msg'] = "Pesanan Anda sudah selesai, silakan kirim SMS ke penumpang...";
            $json['status'] = "sukses";
            $json['id'] = $id;
        } else {
            $json['msg'] = "Sesuatu telah gagal diproses..." . $pool_id;
            $json['status'] = "gagal";
        }
        $this->output->set_content_type('application/json');
        echo json_encode($json);
    }

    public function gotickete()
    {
        $json = array();
        if ($this->session->userdata('group_id') == 1) {
            $pool_id = 3;
        } else {
            $pool_id = $this->session->userdata('pool_id');
        }
        $booking = $this->session->userdata('booking');
        $total_bayar = $booking['harga_tiket'] * $booking['jml_penumpang'];
        $e = $this->perjalanan->get($booking['id_asal']);
        $pemesanan = array(
            // kode_travel mungkin nanti bisa dihapus saja
            'kode_travel'        => $booking['kode_travel'],
            // id_destination mungkin nanti bisa dihapus saja
            'id_destination'    => $booking['id_destination'],
            'pool_id'            => $pool_id,
            //'pool_id'			=> $booking['id_asal'],
            'kode_karcis'        => $booking['kode_karcis'],
            'no_hp'                => $booking['no_hp'],
            'nama_pemesan'        => $booking['nama_pemesan'],
            'nama_penumpang'    => $booking['nama_penumpang'],
            'kode_kursi'        => $booking['kode_kursi'],
            'asal'                 => $booking['asal'],
            'tujuan'             => $booking['tujuan'],
            'destination'        => $booking['destination'],
            'waktu_berangkat'     => $booking['waktu_berangkat'],
            'harga_tiket'        => $booking['harga_tiket'],
            'total_bayar'         => $total_bayar,
            'jumlah_kursi'         => $booking['jml_penumpang'],
            'pesan_via'            => $e->pesan_via,
            'status_bayar'            => $e->status_bayar,
            'bayar_via'            => $e->bayar_via,
            'id_payment'          => $e->id_payment,
            'pindahan'          => $booking['id_asal'],
            'created'             => date('Y-m-d H:i:s'),
            'updated'             => date('Y-m-d H:i:s'),
            'created_by'         => $this->session->userdata['username'],
            'updated_by'         => $this->session->userdata['username']
        );
        $id = $this->perjalanan->save($pemesanan);
        if ($id) {
            $datax = array(
                'id'        =>  $id
            );
            $this->session->set_userdata('selesai', $datax);
            $dataKarcis = $this->penjadwalan->get_tiket_by_kode($booking['kode_karcis']);
            $jumlah_kursi_tersedia = $dataKarcis[0]->jumlah_kursi;
            $kode_kursi_tersedia = $dataKarcis[0]->kode_kursi;
            $kode_kursi_tersedia = explode(',', $kode_kursi_tersedia);
            $kode_kursi_dipesan = explode(',', $booking['kode_kursi']);
            $sisa_kursi = array_diff($kode_kursi_tersedia, $kode_kursi_dipesan);
            $sisa_kursi = implode(',', $sisa_kursi);
            $data = array(
                'jumlah_kursi'    => $jumlah_kursi_tersedia - $booking['jml_penumpang'],
                'kode_kursi'    => $sisa_kursi
            );
            $this->penjadwalan->update_karcis_by_kode_karcis($data, $booking['kode_karcis']);
            $json['msg'] = "Pesanan Anda sudah selesai, silakan kirim SMS ke penumpang...";
            $json['status'] = "sukses";
            $json['id'] = $id;
            if ($e->id_payment != "") {
                $this->pindahe($booking['id_asal']);
            } else {
                $this->pindah($booking['id_asal']);
            }
        } else {
            $json['msg'] = "Sesuatu telah gagal diproses...";
            $json['status'] = "gagal";
        }
        $this->output->set_content_type('application/json');
        echo json_encode($json);
    }

    public function sms()
    {
        $this->data['title'] = 'Data Perjalanan Anda';
        $this->load->view('rdpl/perjalanan/sms', $this->data);
    }
    
    public function sms_testing()
    {
        $this->data['title'] = 'Data Perjalanan Anda';
        $this->load->view('rdpl/perjalanan/sms_testing', $this->data);
    }
    
    public function gowa()
    {
        $booking = $this->session->userdata('booking');
        $selesai = $this->session->userdata('selesai');
        $selesai2 = $this->session->userdata('selesai2');
        $message = 'Pesanan Anda tujuan *' . $booking['destination'] . '* pada *' . $this->input->post('wkt_berangkat') . '* dengan kursi *no. ' . $booking['kode_kursi'] . '* tercatat dengan no.booking *' . $selesai['id'];
        if ($this->input->post('wkt_kembali')) {
            $message2 = '* dan *' . $booking['destination2'] . '* pada *' . $this->input->post('wkt_kembali') . '* dengan kursi *no. ' . $booking['kode_kursi2'] . '* tercatat dengan no.booking *' . $selesai2['id'] . '*.';
        } else {
            $message2 = '*.';
        }
        $key = 'b2d95af932eedb4de92b3496f338aa5f97b36ae0';
        $url = 'https://1d4e-222-124-115-99.ap.ngrok.io/wabotsameit/app/api/send-message';
        
        $data = [
                    'api_key' => 'b2d95af932eedb4de92b3496f338aa5f97b36ae0',
                    'sender'  => '628112030407',
                    'number'  => $booking['no_hp'],
                    'message' => '*Siliwangi Trans :* ' . $message . $message2 . '
Terima kasih. :)

*Catatan : Khusus jadwal jam tambahan (jam ... .01, .02, dst) kursi random, tidak sesuai dengan yang dibooking.* Seat yang sesuai hanya di *Jam .00* yah kak.
          
          *Syarat dan Ketentuan :*
- Anak berusia 2 tahun atau lebih harus membeli tiket.
- Penumpang hanya boleh membawa 1 bagasi berukuran kabin (berat maks. 7 kg). Jika tidak, bagasi akan dibawa dalam kendaraan travel pada jam berikutnya.
- Penumpang dilarang membawa binatang, narkoba, senjata api, senjata tajam, barang-barang terlarang atau ilegal, bahan yang mudah terbakar dan meledak, barang berbau menyengat dan barang yang mungkin mengganggu kenyamanan dan keamanan penumpang lain.
- Toleransi keterlambatan adalah 5 menit dari waktu keberangkatan. Mohon informasikan keterlambatan Anda dengan telepon ke Call Center Siliwangi Trans.
- Waktu keberangkatan, tipe kendaraan, dan rute dapat berubah sewaktu-waktu karena alasan operasional.
- Jika penumpang mengalami kendala apa pun, silahkan langsung hubungi Call Center Siliwangi Trans di 0807 140 1060.

*Reschedule :*
- Pengubahan jadwal hanya bisa dilakukan untuk tiket normal (non-promo).
- Untuk mengubah jadwal, telepon Siliwangi Trans di 0807 140 1060 atau kunjungi Pool Siliwangi Trans terdekat.
- Pengubahan jadwal bisa dilakukan paling lambat 6 jam sebelum keberangkatan.
- Pengubahan jadwal bisa dilakukan hanya bisa 1 kali.
- Pengubahan jadwal bisa dilakukan jika tiket untuk jadwal yang diinginkan masih tersedia.
- Pengubahan jadwal hanya bisa dilakukan maksimal 1 bulan dari tanggal keberangkatan awal.

*Refund :*
- Tiket bus yang sudah dibayar tidak bisa dibatalkan sehingga tidak bisa dilakukan pengembalian dana.
          
          *Call Center 08071401060 WhatsApp wa.me/6281212123140*'
                ];
                
                $curl = curl_init();
                curl_setopt_array($curl, array(
                  CURLOPT_URL => "https://1d4e-222-124-115-99.ap.ngrok.io/wabotsameit/app/api/send-message",
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_ENCODING => "",
                  CURLOPT_MAXREDIRS => 10,
                  CURLOPT_TIMEOUT => 0,
                  CURLOPT_FOLLOWLOCATION => true,
                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                  CURLOPT_CUSTOMREQUEST => "POST",
                  CURLOPT_POSTFIELDS => json_encode($data))
                );
                
                $response = curl_exec($curl);
                
                curl_close($curl);
        redirect('rdpl/perjalanan', 'refresh');
    }
    
    public function gowa_testing()
    {
        $booking = $this->session->userdata('booking');
        $selesai = $this->session->userdata('selesai');
        $selesai2 = $this->session->userdata('selesai2');
        $message = 'Pesanan Anda tujuan *' . $booking['destination'] . '* pada *' . $this->input->post('wkt_berangkat') . '* dengan kursi *no. ' . $booking['kode_kursi'] . '* tercatat dengan no.booking *' . $selesai['id'];
        if ($this->input->post('wkt_kembali')) {
            $message2 = '* dan *' . $booking['destination2'] . '* pada *' . $this->input->post('wkt_kembali') . '* dengan kursi *no. ' . $booking['kode_kursi2'] . '* tercatat dengan no.booking *' . $selesai2['id'] . '*.';
        } else {
            $message2 = '*.';
        }
        $key = 'b2d95af932eedb4de92b3496f338aa5f97b36ae0';
        $url = 'https://1d4e-222-124-115-99.ap.ngrok.io/wabotsameit/app/api/send-message';
        
        $data = [
                    'api_key' => 'b2d95af932eedb4de92b3496f338aa5f97b36ae0',
                    'sender'  => '628112030407',
                    'number'  => $booking['no_hp'],
                    'message' => '*Siliwangi Trans :* ' . $message . $message2 . '
Terima kasih. :)

*Catatan : Khusus jadwal jam tambahan (jam ... .01, .02, dst) kursi random, tidak sesuai dengan yang dibooking.* Seat yang sesuai hanya di *Jam .00* yah kak.
          
          *Syarat dan Ketentuan :*
- Anak berusia 2 tahun atau lebih harus membeli tiket.
- Penumpang hanya boleh membawa 1 bagasi berukuran kabin (berat maks. 7 kg). Jika tidak, bagasi akan dibawa dalam kendaraan travel pada jam berikutnya.
- Penumpang dilarang membawa binatang, narkoba, senjata api, senjata tajam, barang-barang terlarang atau ilegal, bahan yang mudah terbakar dan meledak, barang berbau menyengat dan barang yang mungkin mengganggu kenyamanan dan keamanan penumpang lain.
- Toleransi keterlambatan adalah 5 menit dari waktu keberangkatan. Mohon informasikan keterlambatan Anda dengan telepon ke Call Center Siliwangi Trans.
- Waktu keberangkatan, tipe kendaraan, dan rute dapat berubah sewaktu-waktu karena alasan operasional.
- Jika penumpang mengalami kendala apa pun, silahkan langsung hubungi Call Center Siliwangi Trans di 0807 140 1060.

*Reschedule :*
- Pengubahan jadwal hanya bisa dilakukan untuk tiket normal (non-promo).
- Untuk mengubah jadwal, telepon Siliwangi Trans di 0807 140 1060 atau kunjungi Pool Siliwangi Trans terdekat.
- Pengubahan jadwal bisa dilakukan paling lambat 6 jam sebelum keberangkatan.
- Pengubahan jadwal bisa dilakukan hanya bisa 1 kali.
- Pengubahan jadwal bisa dilakukan jika tiket untuk jadwal yang diinginkan masih tersedia.
- Pengubahan jadwal hanya bisa dilakukan maksimal 1 bulan dari tanggal keberangkatan awal.

*Refund :*
- Tiket bus yang sudah dibayar tidak bisa dibatalkan sehingga tidak bisa dilakukan pengembalian dana.
          
          *Call Center 08071401060 WhatsApp wa.me/6281212123140*'
                ];
                
                $curl = curl_init();
                curl_setopt_array($curl, array(
                  CURLOPT_URL => "https://1d4e-222-124-115-99.ap.ngrok.io/wabotsameit/app/api/send-message",
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_ENCODING => "",
                  CURLOPT_MAXREDIRS => 10,
                  CURLOPT_TIMEOUT => 0,
                  CURLOPT_FOLLOWLOCATION => true,
                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                  CURLOPT_CUSTOMREQUEST => "POST",
                  CURLOPT_POSTFIELDS => json_encode($data))
                );
                
                $response = curl_exec($curl);
                
                curl_close($curl);
        redirect('rdpl/perjalanan/testing', 'refresh');
    }

    public function gowaw()
    {
        $booking = $this->session->userdata('booking');
        $selesai = $this->session->userdata('selesai');
        $selesai2 = $this->session->userdata('selesai2');
        $message = 'Pesanan Anda tujuan *' . $booking['destination'] . '* pada *' . $this->input->post('wkt_berangkat') . '* dengan kursi *no. ' . $booking['kode_kursi'] . '* tercatat dengan no.booking *' . $selesai['id'];
        if ($this->input->post('wkt_kembali')) {
            $message2 = '* dan *' . $booking['destination2'] . '* pada *' . $this->input->post('wkt_kembali') . '* dengan kursi *no. ' . $booking['kode_kursi2'] . '* tercatat dengan no.booking *' . $selesai2['id'] . '*.';
        } else {
            $message2 = '*.';
        }
        $key = 'b2d95af932eedb4de92b3496f338aa5f97b36ae0';
        $url = 'https://1d4e-222-124-115-99.ap.ngrok.io/wabotsameit/app/api/send-message';
        $data = array(
            "number" => substr_replace($booking['no_hp'], '+62', 0, 1),
            "api_key"        => $key,
            "message"    => '*Siliwangi Trans :* ' . $message . $message2 . '
Terima kasih. :)
          
          *Syarat dan Ketentuan :*
- Anak berusia 2 tahun atau lebih harus membeli tiket.
- Penumpang hanya boleh membawa 1 bagasi berukuran kabin (berat maks. 7 kg). Jika tidak, bagasi akan dibawa dalam kendaraan travel pada jam berikutnya.
- Penumpang dilarang membawa binatang, narkoba, senjata api, senjata tajam, barang-barang terlarang atau ilegal, bahan yang mudah terbakar dan meledak, barang berbau menyengat dan barang yang mungkin mengganggu kenyamanan dan keamanan penumpang lain.
- Toleransi keterlambatan adalah 5 menit dari waktu keberangkatan. Mohon informasikan keterlambatan Anda dengan telepon ke Call Center Siliwangi Trans.
- Waktu keberangkatan, tipe kendaraan, dan rute dapat berubah sewaktu-waktu karena alasan operasional.
- Jika penumpang mengalami kendala apa pun, silahkan langsung hubungi Call Center Siliwangi Trans di 0807 140 1060.

*Reschedule :*
- Pengubahan jadwal hanya bisa dilakukan untuk tiket normal (non-promo).
- Untuk mengubah jadwal, telepon Siliwangi Trans di 0807 140 1060 atau kunjungi Pool Siliwangi Trans terdekat.
- Pengubahan jadwal bisa dilakukan paling lambat 6 jam sebelum keberangkatan.
- Pengubahan jadwal bisa dilakukan hanya bisa 1 kali.
- Pengubahan jadwal bisa dilakukan jika tiket untuk jadwal yang diinginkan masih tersedia.
- Pengubahan jadwal hanya bisa dilakukan maksimal 1 bulan dari tanggal keberangkatan awal.

*Refund :*
- Tiket bus yang sudah dibayar tidak bisa dibatalkan sehingga tidak bisa dilakukan pengembalian dana.
          
          *Call Center 08071401060 WhatsApp wa.me/6281212123140*'
        );
        $data_string = json_encode($data);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_VERBOSE, 0);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 360);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data_string)
            )
        );
        echo $res = curl_exec($ch);
        curl_close($ch);
        redirect('rdpl/perjalanan', 'refresh');
    }

    public function gosms()
    {
        /* $booking = $this->session->userdata('booking');
        $selesai = $this->session->userdata('selesai');
        $selesai2 = $this->session->userdata('selesai2');
        if(!empty($selesai2['id'])) {   
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL => 'http://api.nusasms.com/api/v3/sendsms/plain',
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => array(
                    'user' => 'siliwangitrans_api',
                    'password' => '41619T6',
                    'SMSText' => 'ST : Pesanan Anda tujuan '.$booking['destination2'].' pd '.$this->input->post('wkt_kembali').' dg no.kursi '.$booking['kode_kursi2'].' tercatat dg no.booking '.$selesai2['id'].'.Terima kasih. Call Center 0807 1401060.',
                    'GSM' => substr_replace($booking['no_hp'],'62',0,1)
                )
            ));
            $resp = curl_exec($curl);
            if (!$resp) {
                die('Error: "' . curl_error($curl) . '" - Code: ' . curl_errno($curl));
            } else {
                header('Content-type: text/xml'); 
                //echo $resp;
                $sms = array(
                    'booking_id'		=> $selesai2['id'],
                    'no_hp'		=> $booking['no_hp'],
                    // id_destination mungkin nanti bisa dihapus saja
                    'sms'	=> 'ST : Pesanan Anda tujuan '.$booking['destination2'].' pd '.$this->input->post('wkt_kembali').' dg no.kursi '.$booking['kode_kursi2'].' tercatat dg no.booking '.$selesai2['id'].'.Terima kasih. Call Center 0807 1401060.',
                    'type'			=> '0',
                    'created' 			=> date('Y-m-d H:i:s'),
                    'updated' 			=> date('Y-m-d H:i:s'),
                    'created_by' 		=> $this->session->userdata['username'],
                    'updated_by' 		=> $this->session->userdata['username']
                );
                $idx = $this->sms->save($sms);
            }
            curl_close($curl);
        } 
        if(!empty($selesai['id'])) { 
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL => 'http://api.nusasms.com/api/v3/sendsms/plain',
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => array(
                    'user' => 'siliwangitrans_api',
                    'password' => '41619T6',
                    'SMSText' => 'ST : Pesanan Anda tujuan '.$booking['destination'].' pd '.$this->input->post('wkt_berangkat').' dg no.kursi '.$booking['kode_kursi'].' tercatat dg no.booking '.$selesai['id'].'.Terima kasih. Call Center 0807 1401060.',
                    'GSM' => substr_replace($booking['no_hp'],'62',0,1)
                )
            ));
            $resp = curl_exec($curl);
            if (!$resp) {
                die('Error: "' . curl_error($curl) . '" - Code: ' . curl_errno($curl));
            } else {
                header('Content-type: text/xml'); 
                //echo $resp;
                $sms = array(
                    'booking_id'		=> $selesai['id'],
                    'no_hp'		=> $booking['no_hp'],
                    // id_destination mungkin nanti bisa dihapus saja
                    'sms'	=> 'ST : Pesanan Anda tujuan '.$booking['destination'].' pd '.$this->input->post('wkt_berangkat').' dg no.kursi '.$booking['kode_kursi'].' tercatat dg no.booking '.$selesai['id'].'.Terima kasih. Call Center 0807 1401060.',
                    'type'			=> '0',
                    'created' 			=> date('Y-m-d H:i:s'),
                    'updated' 			=> date('Y-m-d H:i:s'),
                    'created_by' 		=> $this->session->userdata['username'],
                    'updated_by' 		=> $this->session->userdata['username']
                );
                $idx = $this->sms->save($sms);
            }
            curl_close($curl);
            $this->session->set_flashdata('message', msg_success('Pesanan selesai dan SMS telah dikirim'));
            redirect('rdpl/perjalanan', 'refresh');
        } else {
            $this->session->set_flashdata('message', msg_error('Pesanan selesai dan SMS gagal dikirim'));
            redirect('rdpl/perjalanan', 'refresh');
        } */
        redirect('rdpl/perjalanan', 'refresh');
    }

    public function bayar($id)
    {
        $this->data['title'] = 'Pembayaran Tiket Perjalanan';
        $t = $this->perjalanan->get($id);
        $this->data['reservation'] = $this->perjalanan->get_by(array(
            'id' => $id
        ));
        $d = $this->destination->get($t->id_destination);
        $tb = strtotime($t->waktu_berangkat);
        $sd = strtotime($d->start_date);
        $ed = strtotime($d->end_date);
        if ($tb < $sd || $tb > $ed) {
            $this->data['hrg'] = $d->harga;
        } elseif ($tb >= $sd || $tb <= $ed) {
            $this->data['hrg'] = $d->harga_baru;
        }
        $this->data['biaya'] = $this->biaya->get();
        $this->data['diskon'] = $this->diskon->diskon_tiket();
        if ($t->status_bayar == "lunas") {
            $this->load->view('rdpl/perjalanan/lunas', $this->data);
        } else {
            $this->load->view('rdpl/perjalanan/bayar', $this->data);
        }
    }

    public function edit($id)
    {
        if ($this->session->userdata['id'] == "76" || $this->session->userdata['group_id'] == "1") {
            $this->data['title'] = 'Edit Tiket Perjalanan';
            $t = $this->perjalanan->get($id);
            $this->data['reservation'] = $this->perjalanan->get_by(array(
                'id' => $id
            ));
            $waktu_berangkat = explode(' ', $t->waktu_berangkat);
            $this->data['result'] = $this->penjadwalan->get_jadwal($t->kode_travel, $t->kode_travel, $waktu_berangkat[0]);
            if ($t->status_bayar == "lunas") {
                if ($t->id_payment != "0") {
                    $this->load->view('rdpl/perjalanan/edit', $this->data);
                } else {
                    $this->load->view('rdpl/perjalanan/lunas', $this->data);
                }
            } else {
                $this->load->view('rdpl/perjalanan/edit', $this->data);
            }
        } else {
            redirect('rdpl/perjalanan/');
        }
    }

    public function lunasx($id)
    {
        $t = $this->perjalanan->get($id);
        $pymid = $this->midtrans->status($t->id_payment)->payment_type;
        $data = array(
            'status_bayar'     => 'lunas',
            'bayar_via'    => 'MidTrans / ' . $pymid,
            'updated'     => date('Y-m-d H:i:s'),
            'updated_by'     => 'MidTrans'
            //'pool_id'	=> $pool_id,
        );
        $this->perjalanan->save($data, $id);
        //$this->session->set_flashdata('message', msg_success('Pemesanan Lunas!'));
    }

    public function lunas($id)
    {
        $t = $this->perjalanan->get($id);
        $d = $this->destination->get($t->id_destination);
        $tb = strtotime($t->waktu_berangkat);
        $sd = strtotime($d->start_date);
        $ed = strtotime($d->end_date);
        if ($tb < $sd || $tb > $ed) {
            $hrg = $d->harga;
        } elseif ($tb >= $sd || $tb <= $ed) {
            $hrg = $d->harga_baru;
        }
        $jam = date('H.i');
        $hari = date('Y-m-d');
        $d = strtotime("tomorrow");
        $d2 = date('Y-m-d', $d);
        if ($this->session->userdata('group_id') == 1) {
            $pool_id = 3;
        } else {
            $pool_id = $this->session->userdata('pool_id');
        }
        $waktu    = $t->waktu_berangkat;
        $waktu_berangkat = explode(' ', $waktu);
        $jampesan = $waktu_berangkat[1];
        $tgl2 = $waktu_berangkat[0];
        $selisih = $jampesan - $jam;
        if ($hari == $tgl2) {
            $penumpang = $t->jumlah_kursi;
            $numberArray = array();
            for ($i = 1; $i <= $penumpang; $i++) {
                $numberArray[$i] = $this->input->post('diskon_' . $i);
            }
            $numberArray2 = array();
            for ($i = 1; $i <= $penumpang; $i++) {
                $numberArray2[$i] = $this->input->post('biaya_' . $i);
            }
            $diskon = array_sum($numberArray);
            $diskon2 = implode(',', $numberArray);
            $biaya = array_sum($numberArray2);
            $biaya2 = implode(',', $numberArray2);
            $total = $hrg * $t->jumlah_kursi;
            $total_bayar = $total - $diskon + $biaya;
            $data = array(
                'total_bayar'      => $total_bayar,
                'harga_tiket'      => $hrg,
                'status_bayar'     => 'lunas',
                'bayar_via'    => $this->input->post('bayar_via'),
                'updated'     => date('Y-m-d H:i:s'),
                'updated_by'     => $this->session->userdata['username'],
                'diskon'    => $diskon2,
                'biaya'           => $biaya2,
                'pool_id'    => $pool_id,
            );
            $this->perjalanan->save($data, $id);
            $this->session->set_flashdata('message', msg_success('Pemesanan Lunas!'));
            redirect('rdpl/perjalanan/bayar/' . $id);
        } elseif ($d2 == $tgl2 && $jampesan < 6) {
            $penumpang = $t->jumlah_kursi;
            $numberArray = array();
            for ($i = 1; $i <= $penumpang; $i++) {
                $numberArray[$i] = $this->input->post('diskon_' . $i);
            }
            $numberArray2 = array();
            for ($i = 1; $i <= $penumpang; $i++) {
                $numberArray2[$i] = $this->input->post('biaya_' . $i);
            }
            $diskon = array_sum($numberArray);
            $diskon2 = implode(',', $numberArray);
            $biaya = array_sum($numberArray2);
            $biaya2 = implode(',', $numberArray2);
            $total = $t->total_bayar;
            $total_bayar = $total - $diskon + $biaya;
            $data = array(
                'total_bayar'      => $total_bayar,
                'harga_tiket'      => $hrg,
                'status_bayar'     => 'lunas',
                'bayar_via'    => $this->input->post('bayar_via'),
                'updated'     => date('Y-m-d H:i:s'),
                'updated_by'     => $this->session->userdata['username'],
                'diskon'    => $diskon2,
                'biaya'           => $biaya2,
                'pool_id'    => $pool_id,
            );
            $this->perjalanan->save($data, $id);
            $this->session->set_flashdata('message', msg_success('Pemesanan Lunas!'));
            redirect('rdpl/perjalanan/bayar/' . $id);
        } else {
            $this->session->set_flashdata('message', msg_success('Pembayaran harus 2 jam sebelum keberangkatan!'));
            redirect('rdpl/perjalanan/bayar/' . $id);
        }
    }

    public function tiket($id)
    {
        $t = $this->perjalanan->get($id);
        if ($t->cetak != "0" && $this->session->userdata('group_id') == 2) {
            $curang = array(
                'ticket'             => $id,
                'type'               => 'perjalanan tiket',
                'created'              => date('Y-m-d H:i:s'),
                'created_by'          => $this->session->userdata['username'],
                'updated'              => date('Y-m-d H:i:s'),
                'updated_by'          => $this->session->userdata['username']
            );
            $this->datas->curang_insert($curang);
            $this->data['title'] = 'Cetak Tiket Gagal';
            $this->load->view('rdpl/perjalanan/cetak_gagal', $this->data);
        } else {
            $data = array(
                'cetak'         => '1',
                'updated'         => date('Y-m-d H:i:s'),
                'updated_by'     => $this->session->userdata['username']
            );
            $this->perjalanan->save($data, $id);
            $cetak = array(
                'ticket'             => $id,
                'type'               => 'perjalanan',
                'created'              => date('Y-m-d H:i:s'),
                'created_by'          => $this->session->userdata['username'],
                'updated'              => date('Y-m-d H:i:s'),
                'updated_by'          => $this->session->userdata['username']
            );
            $this->datas->cetak_insert($cetak);
            $this->data['title'] = 'Cetak Tiket';
            $this->data['reservation'] = $this->perjalanan->get_by(array(
                'id' => $id
            ));
            $this->load->view('rdpl/perjalanan/cetak_tiket', $this->data);
        }
    }

    private function batalx($id)
    {
        $t = $this->perjalanan->get($id);
        if ($t->status_bayar != "lunas") {
            $karcis = $this->penjadwalan->get_tiket_by_kode($t->kode_karcis);
            $karcis = $karcis[0];
            $return_jumlah = $t->jumlah_kursi + $karcis->jumlah_kursi;
            $return_kursi = array_merge(explode(',', $karcis->kode_kursi), explode(',', $t->kode_kursi));
            sort($return_kursi);
            $data = array(
                'jumlah_kursi'     => $return_jumlah,
                'kode_kursi'    => implode(',', $return_kursi)
            );
            $this->penjadwalan->update_kursi_by_kode_karcis($data, $t->kode_karcis);
            $batal = array(
                'kode_travel'          => $t->kode_travel,
                'id_payment'          => $t->id_payment,
                'id_destination'     => $t->id_destination,
                'pool_id'            => $t->pool_id,
                'kode_karcis'        => $t->kode_karcis,
                'nama_pemesan'          => $t->nama_pemesan,
                'asal'               => $t->asal,
                'tujuan'              => $t->tujuan,
                'destination'        => $t->destination,
                'waktu_berangkat'      => $t->waktu_berangkat,
                'no_hp'              => $t->no_hp,
                'jumlah_kursi'       => $t->jumlah_kursi,
                'nama_penumpang'     => $t->nama_penumpang,
                'kode_kursi'          => $t->kode_kursi,
                'harga_tiket'        => $t->harga_tiket,
                'diskon'              => $t->diskon,
                'biaya'              => $t->biaya,
                'total_bayar'          => $t->total_bayar,
                'pesan_via'          => $t->pesan_via,
                'created'              => $t->created,
                'created_by'          => $t->created_by,
                'updated'              => date('Y-m-d H:i:s'),
                'updated_by'          => "MidTrans"
            );
            $this->datas->batal_insert($batal);
            $this->perjalanan->delete($id);
            //echo "success";
        } else {
            $curang = array(
                'ticket'             => $id,
                'type'               => 'perjalanan batal',
                'created'              => date('Y-m-d H:i:s'),
                'created_by'          => $this->session->userdata['username'],
                'updated'              => date('Y-m-d H:i:s'),
                'updated_by'          => $this->session->userdata['username']
            );
            $this->datas->curang_insert($curang);
            //echo "success";
            //echo "Opps, you are cheating!";
        }
    }

    public function batal($id)
    {
        $t = $this->perjalanan->get($id);
        if ($t->status_bayar != "lunas") {
            $karcis = $this->penjadwalan->get_tiket_by_kode($t->kode_karcis);
            $karcis = $karcis[0];
            $return_jumlah = $t->jumlah_kursi + $karcis->jumlah_kursi;
            $return_kursi = array_merge(explode(',', $karcis->kode_kursi), explode(',', $t->kode_kursi));
            sort($return_kursi);
            $data = array(
                'jumlah_kursi'     => $return_jumlah,
                'kode_kursi'    => implode(',', $return_kursi)
            );
            $this->penjadwalan->update_kursi_by_kode_karcis($data, $t->kode_karcis);
            $batal = array(
                'kode_travel'          => $t->kode_travel,
                'id_payment'          => $t->id_payment,
                'id_destination'     => $t->id_destination,
                'pool_id'            => $t->pool_id,
                'kode_karcis'        => $t->kode_karcis,
                'nama_pemesan'          => $t->nama_pemesan,
                'asal'               => $t->asal,
                'tujuan'              => $t->tujuan,
                'destination'        => $t->destination,
                'waktu_berangkat'      => $t->waktu_berangkat,
                'no_hp'              => $t->no_hp,
                'jumlah_kursi'       => $t->jumlah_kursi,
                'nama_penumpang'     => $t->nama_penumpang,
                'kode_kursi'          => $t->kode_kursi,
                'harga_tiket'        => $t->harga_tiket,
                'diskon'              => $t->diskon,
                'biaya'              => $t->biaya,
                'total_bayar'          => $t->total_bayar,
                'pesan_via'          => $t->pesan_via,
                'created'              => $t->created,
                'created_by'          => $t->created_by,
                'updated'              => date('Y-m-d H:i:s'),
                'updated_by'          => $this->session->userdata['username']
            );
            $this->datas->batal_insert($batal);
            $this->perjalanan->delete($id);
            echo "success";
        } else {
            $curang = array(
                'ticket'             => $id,
                'type'               => 'perjalanan batal',
                'created'              => date('Y-m-d H:i:s'),
                'created_by'          => $this->session->userdata['username'],
                'updated'              => date('Y-m-d H:i:s'),
                'updated_by'          => $this->session->userdata['username']
            );
            $this->datas->curang_insert($curang);
            echo "success";
            //echo "Opps, you are cheating!";
        }
    }

    public function batal_bulk()
    {
        foreach ($_POST['myCheckboxes'] as $id => $val) {
            $t = $this->perjalanan->get($val);
            if ($t->status_bayar != "lunas") {
                $karcis = $this->penjadwalan->get_tiket_by_kode($t->kode_karcis);
                $karcis = $karcis[0];
                $return_jumlah = $t->jumlah_kursi + $karcis->jumlah_kursi;
                $return_kursi = array_merge(explode(',', $karcis->kode_kursi), explode(',', $t->kode_kursi));
                sort($return_kursi);
                $data = array(
                    'jumlah_kursi'     => $return_jumlah,
                    'kode_kursi'    => implode(',', $return_kursi)
                );
                $this->penjadwalan->update_kursi_by_kode_karcis($data, $t->kode_karcis);
                $batal = array(
                    'kode_travel'          => $t->kode_travel,
                    'id_payment'          => $t->id_payment,
                    'id_destination'     => $t->id_destination,
                    'pool_id'            => $t->pool_id,
                    'kode_karcis'        => $t->kode_karcis,
                    'nama_pemesan'          => $t->nama_pemesan,
                    'asal'               => $t->asal,
                    'tujuan'              => $t->tujuan,
                    'destination'        => $t->destination,
                    'waktu_berangkat'      => $t->waktu_berangkat,
                    'no_hp'              => $t->no_hp,
                    'jumlah_kursi'       => $t->jumlah_kursi,
                    'nama_penumpang'     => $t->nama_penumpang,
                    'kode_kursi'          => $t->kode_kursi,
                    'harga_tiket'        => $t->harga_tiket,
                    'diskon'              => $t->diskon,
                    'biaya'              => $t->biaya,
                    'total_bayar'          => $t->total_bayar,
                    'pesan_via'          => $t->pesan_via,
                    'created'              => $t->created,
                    'created_by'          => $t->created_by,
                    'updated'              => date('Y-m-d H:i:s'),
                    'updated_by'          => $this->session->userdata['username']
                );
                $this->datas->batal_insert($batal);
                $this->perjalanan->delete($val);
            } else {
                $curang = array(
                    'ticket'             => $val,
                    'type'               => 'perjalanan batal',
                    'created'              => date('Y-m-d H:i:s'),
                    'created_by'          => $this->session->userdata['username'],
                    'updated'              => date('Y-m-d H:i:s'),
                    'updated_by'          => $this->session->userdata['username']
                );
                $this->datas->curang_insert($curang);
            }
        }
        $status = array("STATUS" => "success");
        echo json_encode($status);
    }

    public function pindah($id)
    {
        $t = $this->perjalanan->get($id);
        if ($t->status_bayar != "lunas") {
            $karcis = $this->penjadwalan->get_tiket_by_kode($t->kode_karcis);
            $karcis = $karcis[0];
            $return_jumlah = $t->jumlah_kursi + $karcis->jumlah_kursi;
            $return_kursi = array_merge(explode(',', $karcis->kode_kursi), explode(',', $t->kode_kursi));
            sort($return_kursi);
            $data = array(
                'jumlah_kursi'     => $return_jumlah,
                'kode_kursi'    => implode(',', $return_kursi)
            );
            $this->penjadwalan->update_kursi_by_kode_karcis($data, $t->kode_karcis);
            $pindah = array(
                'pindahan'          => $t->id,
                'kode_travel'          => $t->kode_travel,
                'id_destination'     => $t->id_destination,
                'pool_id'            => $t->pool_id,
                'kode_karcis'        => $t->kode_karcis,
                'nama_pemesan'          => $t->nama_pemesan,
                'asal'               => $t->asal,
                'tujuan'              => $t->tujuan,
                'destination'        => $t->destination,
                'waktu_berangkat'      => $t->waktu_berangkat,
                'no_hp'              => $t->no_hp,
                'jumlah_kursi'       => $t->jumlah_kursi,
                'nama_penumpang'     => $t->nama_penumpang,
                'kode_kursi'          => $t->kode_kursi,
                'harga_tiket'        => $t->harga_tiket,
                'diskon'              => $t->diskon,
                'biaya'              => $t->biaya,
                'total_bayar'          => $t->total_bayar,
                'pesan_via'          => $t->pesan_via,
                'created'              => $t->created,
                'created_by'          => $t->created_by,
                'updated'              => date('Y-m-d H:i:s'),
                'updated_by'          => $this->session->userdata['username']
            );
            $this->datas->pindah_insert($pindah);
            $this->perjalanan->delete($id);
            //$this->session->set_flashdata('message', msg_success('Pemesanan dipindahkan'));
            //echo redirect('rdpl/perjalanan');
        } else {
            $curang = array(
                'ticket'             => $id,
                'type'               => 'perjalanan pindah',
                'created'              => date('Y-m-d H:i:s'),
                'created_by'          => $this->session->userdata['username'],
                'updated'              => date('Y-m-d H:i:s'),
                'updated_by'          => $this->session->userdata['username']
            );
            $this->datas->curang_insert($curang);
            //redirect('rdpl/perjalanan');
            //echo "Opps, you are cheating!";
        }
    }

    public function pindahe($id)
    {
        $t = $this->perjalanan->get($id);
        //if($t->status_bayar != "lunas") {
        $karcis = $this->penjadwalan->get_tiket_by_kode($t->kode_karcis);
        $karcis = $karcis[0];
        $return_jumlah = $t->jumlah_kursi + $karcis->jumlah_kursi;
        $return_kursi = array_merge(explode(',', $karcis->kode_kursi), explode(',', $t->kode_kursi));
        sort($return_kursi);
        $data = array(
            'jumlah_kursi'     => $return_jumlah,
            'kode_kursi'    => implode(',', $return_kursi)
        );
        $this->penjadwalan->update_kursi_by_kode_karcis($data, $t->kode_karcis);
        $pindah = array(
            'pindahan'          => $t->id,
            'kode_travel'          => $t->kode_travel,
            'id_destination'     => $t->id_destination,
            'pool_id'            => $t->pool_id,
            'kode_karcis'        => $t->kode_karcis,
            'nama_pemesan'          => $t->nama_pemesan,
            'asal'               => $t->asal,
            'tujuan'              => $t->tujuan,
            'destination'        => $t->destination,
            'waktu_berangkat'      => $t->waktu_berangkat,
            'no_hp'              => $t->no_hp,
            'jumlah_kursi'       => $t->jumlah_kursi,
            'nama_penumpang'     => $t->nama_penumpang,
            'kode_kursi'          => $t->kode_kursi,
            'harga_tiket'        => $t->harga_tiket,
            'diskon'              => $t->diskon,
            'biaya'              => $t->biaya,
            'total_bayar'          => $t->total_bayar,
            'pesan_via'          => $t->pesan_via,
            'created'              => $t->created,
            'created_by'          => $t->created_by,
            'updated'              => date('Y-m-d H:i:s'),
            'updated_by'          => $this->session->userdata['username']
        );
        $this->datas->pindah_insert($pindah);
        $this->perjalanan->delete($id);
        //$this->session->set_flashdata('message', msg_success('Pemesanan dipindahkan'));
        //echo redirect('rdpl/perjalanan');
        //} else {
        /* $curang = array(
                'ticket'             => $id,
                'type'               => 'perjalanan pindah',
                'created' 	         => date('Y-m-d H:i:s'),
                'created_by' 	     => $this->session->userdata['username'],
                'updated' 	         => date('Y-m-d H:i:s'),
                'updated_by' 	     => $this->session->userdata['username']
            );
            $this->datas->curang_insert($curang); */
        //redirect('rdpl/perjalanan');
        //echo "Opps, you are cheating!";
        //}
    }

    public function salah($id)
    {
        $t = $this->perjalanan->get($id);
        if ($t->status_bayar != "lunas") {
            $karcis = $this->penjadwalan->get_tiket_by_kode($t->kode_karcis);
            $karcis = $karcis[0];
            $return_jumlah = $t->jumlah_kursi + $karcis->jumlah_kursi;
            $return_kursi = array_merge(explode(',', $karcis->kode_kursi), explode(',', $t->kode_kursi));
            sort($return_kursi);
            $data = array(
                'jumlah_kursi'     => $return_jumlah,
                'kode_kursi'    => implode(',', $return_kursi)
            );
            $this->penjadwalan->update_kursi_by_kode_karcis($data, $t->kode_karcis);
            $salah = array(
                'kode_travel'          => $t->kode_travel,
                'id_destination'     => $t->id_destination,
                'pool_id'            => $t->pool_id,
                'kode_karcis'        => $t->kode_karcis,
                'nama_pemesan'          => $t->nama_pemesan,
                'asal'               => $t->asal,
                'tujuan'              => $t->tujuan,
                'destination'        => $t->destination,
                'waktu_berangkat'      => $t->waktu_berangkat,
                'no_hp'              => $t->no_hp,
                'jumlah_kursi'       => $t->jumlah_kursi,
                'nama_penumpang'     => $t->nama_penumpang,
                'kode_kursi'          => $t->kode_kursi,
                'harga_tiket'        => $t->harga_tiket,
                'diskon'              => $t->diskon,
                'biaya'              => $t->biaya,
                'total_bayar'          => $t->total_bayar,
                'pesan_via'          => $t->pesan_via,
                'created'              => $t->created,
                'created_by'          => $t->created_by,
                'updated'              => date('Y-m-d H:i:s'),
                'updated_by'          => $this->session->userdata['username']
            );
            $this->datas->salah_insert($salah);
            $this->perjalanan->delete($id);
            $this->session->set_flashdata('message', msg_success('Pemesanan salah'));
            redirect('rdpl/perjalanan');
        } else {
            $curang = array(
                'ticket'             => $id,
                'type'               => 'perjalanan salah',
                'created'              => date('Y-m-d H:i:s'),
                'created_by'          => $this->session->userdata['username'],
                'updated'              => date('Y-m-d H:i:s'),
                'updated_by'          => $this->session->userdata['username']
            );
            $this->datas->curang_insert($curang);
            redirect('rdpl/perjalanan');
            //echo "Opps, you are cheating!";
        }
    }

    public function laporan()
    {
        if ($this->session->userdata('group_id') == 1 || $this->session->userdata('group_id') == 3 || $this->session->userdata('group_id') == 4) {
            $this->data['title'] = 'Laporan Perjalanan';
            $this->load->view('rdpl/perjalanan/laporan', $this->data);
        } else {
            redirect('rdpl/perjalanan');
        }
    }

    public function datalaporan()
    {
        if ($this->session->userdata('group_id') == 1 || $this->session->userdata('group_id') == 3 || $this->session->userdata('group_id') == 4) {
            $this->data['title'] = 'Laporan Perjalanan';
            if ($this->session->userdata('group_id') == 1) {
                $pool = $this->input->post('pool');
            } else {
                $pool = $this->session->userdata('pool_id');
            }
            $tgl_awal = $this->input->post('tgl_awal');
            $tgl_akhir = $this->input->post('tgl_akhir');
            $data = array(
                'pool_id' => $pool,
                'tgl_awal' => $tgl_awal,
                'tgl_akhir' => $tgl_akhir
            );
            if ($pool == "all") {
                $this->data['nama_pool'] = 'Semua Pool';
            } else {
                $this->data['nama_pool'] = $this->pool->get_nama($pool);
            }
            $this->data['awal'] = $tgl_awal;
            $this->data['akhir'] = $tgl_akhir;
            $this->session->set_userdata('header', $data);
            if ($tgl_awal === $tgl_akhir) {
                $this->data['cst'] = $this->perjalanan->get_daily_count_report($pool, $tgl_awal, '');
                $this->data['csk'] = $this->perjalanan->get_daily_count_kursi($pool, $tgl_awal, '');
                $this->data['cj'] = $this->perjalanan->get_daily_jam($pool, $tgl_awal, '');
                $this->data['ch'] = $this->perjalanan->get_daily_hari($pool, $tgl_awal, '');
                $this->data['cd'] = $this->perjalanan->get_daily_des($pool, $tgl_awal, '');
                $this->data['cps'] = $this->perjalanan->get_daily_pesan($pool, $tgl_awal, '');
                $this->data['cby'] = $this->perjalanan->get_daily_bayar($pool, $tgl_awal, '');
                $this->data['cbyy'] = $this->perjalanan->get_daily_bayarnominal($pool, $tgl_awal, '');
                $this->data['cpa'] = $this->perjalanan->get_daily_admin($pool, $tgl_awal, '');
            } else {
                $this->data['cst'] = $this->perjalanan->get_daily_count_report($pool, $tgl_awal, $tgl_akhir);
                $this->data['csk'] = $this->perjalanan->get_daily_count_kursi($pool, $tgl_awal, $tgl_akhir);
                $this->data['cj'] = $this->perjalanan->get_daily_jam($pool, $tgl_awal, $tgl_akhir);
                $this->data['ch'] = $this->perjalanan->get_daily_hari($pool, $tgl_awal, $tgl_akhir);
                $this->data['cd'] = $this->perjalanan->get_daily_des($pool, $tgl_awal, $tgl_akhir);
                $this->data['cps'] = $this->perjalanan->get_daily_pesan($pool, $tgl_awal, $tgl_akhir);
                $this->data['cby'] = $this->perjalanan->get_daily_bayar($pool, $tgl_awal, $tgl_akhir);
                $this->data['cbyy'] = $this->perjalanan->get_daily_bayarnominal($pool, $tgl_awal, $tgl_akhir);
                $this->data['cpa'] = $this->perjalanan->get_daily_admin($pool, $tgl_awal, $tgl_akhir);
            }
            $this->data['admins'] = $this->user->get_by(array('group_id' => '2'));
            $this->load->view('rdpl/perjalanan/datalaporan', $this->data);
        } else {
            redirect('rdpl/perjalanan');
        }
    }

    public function ajax_laporan()
    {
        $list = $this->perjalanan->get_report();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $perjalanan) {
            $waktu_berangkat = explode(' ', $perjalanan->waktu_berangkat);
            $pesan = explode(' ', $perjalanan->created);
            if ($perjalanan->status_bayar == 'belum lunas') {
                $btn = "<div class='btn-group' id='" . $perjalanan->id . "'>";
                $btn .= "<a href='" . base_url('rdpl/perjalanan/bayar/' . $perjalanan->id) . "' class='btn btn-primary'><i class='fa fa-cash-register'></i></a>";
                $btn .= "<button type='button' data-target='rdpl/perjalanan/batal' data-id='" . $perjalanan->id . "' onclick='deletethis(this)' class='btn btn-danger'><i class='fa fa-times'></i></button>";
                /* $btn .= "<a href='".base_url('rdpl/perjalanan/pindah/'.$perjalanan->id)."' class='dropdown-item'>Pindah</a>";
                $btn .= "<a href='".base_url('rdpl/perjalanan/salah/'.$perjalanan->id)."' class='dropdown-item'>Salah</a>"; */
                $btn .= "</div>";
                $stt = label_grey(ucfirst($perjalanan->status_bayar));
            } else {
                $btn = "<a href='#' onClick='popup_print(this)' data-id='" . $perjalanan->id . "' class='btn btn-success'><i class='fa fa-ticket-alt'></i></a>";
                $stt = label_green(ucfirst($perjalanan->status_bayar));
            }
            /* if($perjalanan->id_payment != "0") {
                $stmid = $this->midtrans->status($perjalanan->id_payment)->transaction_status;
                $pymid = $this->midtrans->status($perjalanan->id_payment)->payment_type;
                if($stmid == "expire") {
                    $this->batalx($perjalanan->id);
                    $smid = label_green(ucfirst($stmid).' / '.ucfirst($pymid));
                    $btn = label_grey(ucfirst($stmid));
                } else if($stmid == "settlement" || $stmid == "capture") {
                    //$this->lunasx($perjalanan->id);
                    $smid = label_green(ucfirst($stmid).' / '.ucfirst($pymid));
                    $stt = label_green('Lunas');
                    $btn = "<a href='#' onClick='popup_print(this)' data-id='".$perjalanan->id."' class='btn btn-success'><i class='fa fa-ticket-alt'></i></a>";
                } else if($stmid == "pending") {
                    $smid = label_grey(ucfirst($stmid).' / '.ucfirst($pymid));
                    $btn = label_grey(ucfirst($stmid));
                } else {
                    $smid = label_green(ucfirst($stmid).' / '.ucfirst($pymid));
                }
                $mid = $perjalanan->id_payment.'<br/>'.$smid;
            } else {
                $mid = "";
            } */
            $mid = $perjalanan->id_payment;
            $row = array();
            $row[] = $perjalanan->id;
            $row[] = $mid;
            $row[] = $perjalanan->nama_pemesan . "<br/>" . $perjalanan->no_hp;
            $row[] = $perjalanan->destination . " / Kursi " . $perjalanan->kode_kursi . "<br/><small>" . date_format_id($waktu_berangkat[0]) . " " . $waktu_berangkat[1] . " WIB</small>";
            $row[] = 'Rp. ' . number_format($perjalanan->total_bayar) . "<br/>" . $stt;
            $row[] = 'Rp. ' . number_format($perjalanan->diskon);
            $row[] = $perjalanan->created_by . "<br/><small>" . date_format_id($pesan[0]) . " " . $pesan[1] . " WIB</small>";
            $row[] = $btn;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->perjalanan->count_latest_all(),
            "recordsFiltered" => $this->perjalanan->count_report_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function cetaklaporan()
    {
        $header = $this->session->userdata('header');
        $this->data['awal'] = $header['tgl_awal'];
        $this->data['akhir'] = $header['tgl_akhir'];
        if ($header['pool_id'] == "all") {
            $this->data['nama_pool'] = 'Semua-Pool';
        } else {
            $this->data['nama_pool'] = $this->pool->get_nama($header['pool_id']);
        }
        if ($header['tgl_awal'] === $header['tgl_akhir']) {
            $this->data['reservation'] = $this->perjalanan->get_daily_report($header['pool_id'], $header['tgl_awal'], '');
            $this->data['cst'] = $this->perjalanan->get_daily_count_report($header['pool_id'], $header['tgl_awal'], '');
            $this->data['csk'] = $this->perjalanan->get_daily_count_kursi($header['pool_id'], $header['tgl_awal'], '');
            $this->data['cj'] = $this->perjalanan->get_daily_jam($header['pool_id'], $header['tgl_awal'], '');
            $this->data['ch'] = $this->perjalanan->get_daily_hari($header['pool_id'], $header['tgl_awal'], '');
            $this->data['cd'] = $this->perjalanan->get_daily_des($header['pool_id'], $header['tgl_awal'], '');
            $this->data['cps'] = $this->perjalanan->get_daily_pesan($header['pool_id'], $header['tgl_awal'], '');
            $this->data['cby'] = $this->perjalanan->get_daily_bayar($header['pool_id'], $header['tgl_awal'], '');
            $this->data['cbyy'] = $this->perjalanan->get_daily_bayarnominal($header['pool_id'], $header['tgl_awal'], '');
            $this->data['cpa'] = $this->perjalanan->get_daily_admin($header['pool_id'], $header['tgl_awal'], '');
        } else {
            $this->data['reservation'] = $this->perjalanan->get_daily_report($header['pool_id'], $header['tgl_awal'], $header['tgl_akhir']);
            $this->data['cst'] = $this->perjalanan->get_daily_count_report($header['pool_id'], $header['tgl_awal'], $header['tgl_akhir']);
            $this->data['csk'] = $this->perjalanan->get_daily_count_kursi($header['pool_id'], $header['tgl_awal'], $header['tgl_akhir']);
            $this->data['cj'] = $this->perjalanan->get_daily_jam($header['pool_id'], $header['tgl_awal'], $header['tgl_akhir']);
            $this->data['ch'] = $this->perjalanan->get_daily_hari($header['pool_id'], $header['tgl_awal'], $header['tgl_akhir']);
            $this->data['cd'] = $this->perjalanan->get_daily_des($header['pool_id'], $header['tgl_awal'], $header['tgl_akhir']);
            $this->data['cps'] = $this->perjalanan->get_daily_pesan($header['pool_id'], $header['tgl_awal'], $header['tgl_akhir']);
            $this->data['cby'] = $this->perjalanan->get_daily_bayar($header['pool_id'], $header['tgl_awal'], $header['tgl_akhir']);
            $this->data['cbyy'] = $this->perjalanan->get_daily_bayarnominal($header['pool_id'], $header['tgl_awal'], $header['tgl_akhir']);
            $this->data['cpa'] = $this->perjalanan->get_daily_admin($header['pool_id'], $header['tgl_awal'], $header['tgl_akhir']);
        }
        // $this->db->order_by('date(waktu_berangkat)', 'desc');
        $this->load->view('rdpl/perjalanan/cetaklaporan', $this->data);
    }

    public function midtrans()
    {
        if ($this->session->userdata('group_id') == 1 || $this->session->userdata('group_id') == 3) {
            $this->data['title'] = 'Laporan Midtrans';
            $this->load->view('rdpl/perjalanan/midtrans', $this->data);
        } else {
            redirect('rdpl/perjalanan');
        }
    }

    public function datamidtrans()
    {
        if ($this->session->userdata('group_id') == 1 || $this->session->userdata('group_id') == 3) {
            $this->data['title'] = 'Laporan Midtrans';
            $tgl_awal = $this->input->post('tgl_awal');
            $tgl_akhir = $this->input->post('tgl_akhir');
            $data = array(
                'tgl_awal' => $tgl_awal,
                'tgl_akhir' => $tgl_akhir
            );
            $this->data['nama_pool'] = 'MidTrans';
            $this->data['awal'] = $tgl_awal;
            $this->data['akhir'] = $tgl_akhir;
            $this->session->set_userdata('header', $data);
            if ($tgl_awal === $tgl_akhir) {
                $this->data['cst'] = $this->mid->get_daily_count_report($tgl_awal, '');
                $this->data['csk'] = $this->mid->get_daily_count_kursi($tgl_awal, '');
                $this->data['cj'] = $this->mid->get_daily_jam($tgl_awal, '');
                $this->data['ch'] = $this->mid->get_daily_hari($tgl_awal, '');
                $this->data['cd'] = $this->mid->get_daily_des($tgl_awal, '');
                $this->data['cps'] = $this->mid->get_daily_pesan($tgl_awal, '');
                $this->data['cby'] = $this->mid->get_daily_bayar($tgl_awal, '');
                $this->data['cpa'] = $this->mid->get_daily_admin($tgl_awal, '');
            } else {
                $this->data['cst'] = $this->mid->get_daily_count_report($tgl_awal, $tgl_akhir);
                $this->data['csk'] = $this->mid->get_daily_count_kursi($tgl_awal, $tgl_akhir);
                $this->data['cj'] = $this->mid->get_daily_jam($tgl_awal, $tgl_akhir);
                $this->data['ch'] = $this->mid->get_daily_hari($tgl_awal, $tgl_akhir);
                $this->data['cd'] = $this->mid->get_daily_des($tgl_awal, $tgl_akhir);
                $this->data['cps'] = $this->mid->get_daily_pesan($tgl_awal, $tgl_akhir);
                $this->data['cby'] = $this->mid->get_daily_bayar($tgl_awal, $tgl_akhir);
                $this->data['cpa'] = $this->mid->get_daily_admin($tgl_awal, $tgl_akhir);
            }
            $this->data['admins'] = $this->user->get_by(array('group_id' => '2'));
            $this->load->view('rdpl/perjalanan/datamidtrans', $this->data);
        } else {
            redirect('rdpl/perjalanan');
        }
    }

    public function ajax_midtrans()
    {
        $list = $this->mid->get_report();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $perjalanan) {
            $waktu_berangkat = explode(' ', $perjalanan->waktu_berangkat);
            $pesan = explode(' ', $perjalanan->created);
            if ($perjalanan->status_bayar == 'belum lunas') {
                $btn = "<div class='btn-group' id='" . $perjalanan->id . "'>";
                $btn .= "<a href='" . base_url('rdpl/perjalanan/bayar/' . $perjalanan->id) . "' class='btn btn-primary'><i class='fa fa-cash-register'></i></a>";
                $btn .= "<button type='button' data-target='rdpl/perjalanan/batal' data-id='" . $perjalanan->id . "' onclick='deletethis(this)' class='btn btn-danger'><i class='fa fa-times'></i></button>";
                /* $btn .= "<a href='".base_url('rdpl/perjalanan/pindah/'.$perjalanan->id)."' class='dropdown-item'>Pindah</a>";
                $btn .= "<a href='".base_url('rdpl/perjalanan/salah/'.$perjalanan->id)."' class='dropdown-item'>Salah</a>"; */
                $btn .= "</div>";
                $stt = label_grey(ucfirst($perjalanan->status_bayar));
            } else {
                $btn = "<a href='#' onClick='popup_print(this)' data-id='" . $perjalanan->id . "' class='btn btn-success'><i class='fa fa-ticket-alt'></i></a>";
                $stt = label_green(ucfirst($perjalanan->status_bayar));
            }
            /* if($perjalanan->id_payment != "0") {
                $stmid = $this->midtrans->status($perjalanan->id_payment)->transaction_status;
                $pymid = $this->midtrans->status($perjalanan->id_payment)->payment_type;
                if($stmid == "expire") {
                    $this->batalx($perjalanan->id);
                    $smid = label_green(ucfirst($stmid).' / '.ucfirst($pymid));
                    $btn = label_grey(ucfirst($stmid));
                } else if($stmid == "settlement" || $stmid == "capture") {
                    //$this->lunasx($perjalanan->id);
                    $smid = label_green(ucfirst($stmid).' / '.ucfirst($pymid));
                    $stt = label_green('Lunas');
                    $btn = "<a href='#' onClick='popup_print(this)' data-id='".$perjalanan->id."' class='btn btn-success'><i class='fa fa-ticket-alt'></i></a>";
                } else if($stmid == "pending") {
                    $smid = label_grey(ucfirst($stmid).' / '.ucfirst($pymid));
                    $btn = label_grey(ucfirst($stmid));
                } else {
                    $smid = label_green(ucfirst($stmid).' / '.ucfirst($pymid));
                }
                $mid = $perjalanan->id_payment.'<br/>'.$smid;
            } else {
                $mid = "";
            } */
            //$btn ='';
            $mid = $perjalanan->id_payment;
            $row = array();
            $row[] = $perjalanan->id;
            $row[] = $mid;
            $row[] = $perjalanan->nama_pemesan . "<br/>" . $perjalanan->no_hp;
            $row[] = $perjalanan->destination . " / Kursi " . $perjalanan->kode_kursi . "<br/><small>" . date_format_id($waktu_berangkat[0]) . " " . $waktu_berangkat[1] . " WIB</small>";
            $row[] = 'Rp. ' . number_format($perjalanan->total_bayar) . "<br/>" . $stt;
            $row[] = 'Rp. ' . number_format($perjalanan->diskon);
            $row[] = $perjalanan->created_by . "<br/><small>" . date_format_id($pesan[0]) . " " . $pesan[1] . " WIB</small>";
            $row[] = $btn;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->mid->count_latest_all(),
            "recordsFiltered" => $this->mid->count_report_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function cetakmidtrans()
    {
        $header = $this->session->userdata('header');
        $this->data['awal'] = $header['tgl_awal'];
        $this->data['akhir'] = $header['tgl_akhir'];
        $this->data['nama_pool'] = 'MidTrans';
        if ($header['tgl_awal'] === $header['tgl_akhir']) {
            $this->data['reservation'] = $this->mid->get_daily_report($header['tgl_awal'], '');
            $this->data['cst'] = $this->mid->get_daily_count_report($header['tgl_awal'], '');
            $this->data['csk'] = $this->mid->get_daily_count_kursi($header['tgl_awal'], '');
            $this->data['cj'] = $this->mid->get_daily_jam($header['tgl_awal'], '');
            $this->data['ch'] = $this->mid->get_daily_hari($header['tgl_awal'], '');
            $this->data['cd'] = $this->mid->get_daily_des($header['tgl_awal'], '');
            $this->data['cps'] = $this->mid->get_daily_pesan($header['tgl_awal'], '');
            $this->data['cby'] = $this->mid->get_daily_bayar($header['tgl_awal'], '');
            $this->data['cpa'] = $this->mid->get_daily_admin($header['tgl_awal'], '');
        } else {
            $this->data['reservation'] = $this->mid->get_daily_report($header['tgl_awal'], $header['tgl_akhir']);
            $this->data['cst'] = $this->mid->get_daily_count_report($header['tgl_awal'], $header['tgl_akhir']);
            $this->data['csk'] = $this->mid->get_daily_count_kursi($header['tgl_awal'], $header['tgl_akhir']);
            $this->data['cj'] = $this->mid->get_daily_jam($header['tgl_awal'], $header['tgl_akhir']);
            $this->data['ch'] = $this->mid->get_daily_hari($header['tgl_awal'], $header['tgl_akhir']);
            $this->data['cd'] = $this->mid->get_daily_des($header['tgl_awal'], $header['tgl_akhir']);
            $this->data['cps'] = $this->mid->get_daily_pesan($header['tgl_awal'], $header['tgl_akhir']);
            $this->data['cby'] = $this->mid->get_daily_bayar($header['tgl_awal'], $header['tgl_akhir']);
            $this->data['cpa'] = $this->mid->get_daily_admin($header['tgl_awal'], $header['tgl_akhir']);
        }
        $this->db->order_by('date(waktu_berangkat)', 'desc');
        $this->load->view('rdpl/perjalanan/cetakmidtrans', $this->data);
    }

    public function laporan_pembayaran()
    {
        if ($this->session->userdata('group_id') == 1 || $this->session->userdata('group_id') == 5 || $this->session->userdata('group_id') == 6) {
            $this->data['title'] = 'Laporan Pembayaran';
            $this->load->view('rdpl/perjalanan/laporan_pembayaran', $this->data);
        } else {
            redirect('rdpl/perjalanan');
        }
    }

    public function datalaporan_pembayaran()
    {
        if ($this->session->userdata('group_id') == 1 || $this->session->userdata('group_id') == 5 || $this->session->userdata('group_id') == 6) {
            $this->data['title'] = 'Laporan Pembayaran';
            $bv = $this->input->post('bv');
            $tgl_awal = $this->input->post('tgl_awal');
            $tgl_akhir = $this->input->post('tgl_akhir');
            $data = array(
                'bv' => $bv,
                'tgl_awal' => $tgl_awal,
                'tgl_akhir' => $tgl_akhir
            );
            $this->data['nama_pool'] = 'MidTrans';
            $this->data['bv'] = $bv;
            $this->data['awal'] = $tgl_awal;
            $this->data['akhir'] = $tgl_akhir;
            $this->session->set_userdata('header', $data);
            $this->data['total_potongan'] = $this->mid->get_potongan($bv, $tgl_awal, $tgl_akhir);
            if ($tgl_awal === $tgl_akhir) {
                $this->data['cst'] = $this->mid->get_daily_count_report_payment($bv, $tgl_awal, '');
                $this->data['csk'] = $this->mid->get_daily_count_kursi_payment($bv, $tgl_awal, '');
                // $this->data['cj'] = $this->mid->get_daily_jam_payment($bv, $tgl_awal, '');
                $this->data['ch'] = $this->mid->get_daily_hari_payment($bv, $tgl_awal, '');
                $this->data['cd'] = $this->mid->get_daily_des_payment($bv, $tgl_awal, '');
                $this->data['cps'] = $this->mid->get_daily_pesan_payment($bv, $tgl_awal, '');
                $this->data['cby'] = $this->mid->get_daily_bayar_payment($bv, $tgl_awal, '');
                $this->data['cpa'] = $this->mid->get_daily_admin_payment($bv, $tgl_awal, '');
            } else {
                $this->data['cst'] = $this->mid->get_daily_count_report_payment($bv, $tgl_awal, $tgl_akhir);
                $this->data['csk'] = $this->mid->get_daily_count_kursi_payment($bv, $tgl_awal, $tgl_akhir);
                // $this->data['cj'] = $this->mid->get_daily_jam_payment($bv, $tgl_awal, $tgl_akhir);
                $this->data['ch'] = $this->mid->get_daily_hari_payment($bv, $tgl_awal, $tgl_akhir);
                $this->data['cd'] = $this->mid->get_daily_des_payment($bv, $tgl_awal, $tgl_akhir);
                $this->data['cps'] = $this->mid->get_daily_pesan_payment($bv, $tgl_awal, $tgl_akhir);
                $this->data['cby'] = $this->mid->get_daily_bayar_payment($bv, $tgl_awal, $tgl_akhir);
                $this->data['cpa'] = $this->mid->get_daily_admin_payment($bv, $tgl_awal, $tgl_akhir);
            }
            $this->data['admins'] = $this->user->get_by(array('group_id' => '2'));
            $this->load->view('rdpl/perjalanan/datalaporan_pembayaran', $this->data);
        } else {
            redirect('rdpl/perjalanan');
        }
    }

    public function ajax_laporan_pembayaran()
    {
        $list = $this->mid->get_report_pembayaran();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $perjalanan) {
            $waktu_berangkat = explode(' ', $perjalanan->waktu_berangkat);
            $pesan = explode(' ', $perjalanan->created);
            if ($perjalanan->status_bayar == 'belum lunas') {
                $btn = "<div class='btn-group' id='" . $perjalanan->id . "'>";
                $btn .= "<a href='" . base_url('rdpl/perjalanan/bayar/' . $perjalanan->id) . "' class='btn btn-primary'><i class='fa fa-cash-register'></i></a>";
                $btn .= "<button type='button' data-target='rdpl/perjalanan/batal' data-id='" . $perjalanan->id . "' onclick='deletethis(this)' class='btn btn-danger'><i class='fa fa-times'></i></button>";
                /* $btn .= "<a href='".base_url('rdpl/perjalanan/pindah/'.$perjalanan->id)."' class='dropdown-item'>Pindah</a>";
                $btn .= "<a href='".base_url('rdpl/perjalanan/salah/'.$perjalanan->id)."' class='dropdown-item'>Salah</a>"; */
                $btn .= "</div>";
                $stt = label_grey(ucfirst($perjalanan->status_bayar));
            } else {
                $btn = "<a href='#' onClick='popup_print(this)' data-id='" . $perjalanan->id . "' class='btn btn-success'><i class='fa fa-ticket-alt'></i></a>";
                $stt = label_green(ucfirst($perjalanan->status_bayar));
            }
            /* if($perjalanan->id_payment != "0") {
                $stmid = $this->midtrans->status($perjalanan->id_payment)->transaction_status;
                $pymid = $this->midtrans->status($perjalanan->id_payment)->payment_type;
                if($stmid == "expire") {
                    $this->batalx($perjalanan->id);
                    $smid = label_green(ucfirst($stmid).' / '.ucfirst($pymid));
                    $btn = label_grey(ucfirst($stmid));
                } else if($stmid == "settlement" || $stmid == "capture") {
                    //$this->lunasx($perjalanan->id);
                    $smid = label_green(ucfirst($stmid).' / '.ucfirst($pymid));
                    $stt = label_green('Lunas');
                    $btn = "<a href='#' onClick='popup_print(this)' data-id='".$perjalanan->id."' class='btn btn-success'><i class='fa fa-ticket-alt'></i></a>";
                } else if($stmid == "pending") {
                    $smid = label_grey(ucfirst($stmid).' / '.ucfirst($pymid));
                    $btn = label_grey(ucfirst($stmid));
                } else {
                    $smid = label_green(ucfirst($stmid).' / '.ucfirst($pymid));
                }
                $mid = $perjalanan->id_payment.'<br/>'.$smid;
            } else {
                $mid = "";
            } */
            //$btn ='';
            $mid = $perjalanan->id_payment;
            $row = array();
            $row[] = $perjalanan->id;
            $row[] = $mid;
            $row[] = $perjalanan->nama_pemesan . "<br/>" . $perjalanan->no_hp;
            $row[] = $perjalanan->destination . " / Kursi " . $perjalanan->kode_kursi . "<br/><small>" . date_format_id($waktu_berangkat[0]) . " " . $waktu_berangkat[1] . " WIB</small>";
            $row[] = 'Rp. ' . number_format($perjalanan->total_bayar) . "<br/>" . $stt;
            $row[] = 'Rp. ' . number_format($this->mid->get_potongan_by_id($perjalanan->id));
            $row[] = 'Rp. ' . number_format($perjalanan->total_bayar - $this->mid->get_potongan_by_id($perjalanan->id));
            $row[] = $perjalanan->created_by . "<br/><small>" . date_format_id($pesan[0]) . " " . $pesan[1] . " WIB</small>";
            $row[] = $btn;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->mid->count_latest_pembayaran_all(),
            "recordsFiltered" => $this->mid->count_report_pembayaran_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function cetaklaporan_pembayaran()
    {
        $header = $this->session->userdata('header');
        $bv = $header['bv'];
        $tgl_awal = $header['tgl_awal'];
        $tgl_akhir = $header['tgl_akhir'];
        $this->data['awal'] = $header['tgl_awal'];
        $this->data['akhir'] = $header['tgl_akhir'];
        $this->data['nama_pool'] = 'MidTrans';
        $this->data['list'] = $this->mid->get_report_pembayaran2();
        $this->data['total_potongan'] = $this->mid->get_potongan($bv, $tgl_awal, $tgl_akhir);
        if ($tgl_awal === $tgl_akhir) {
            $this->data['cst'] = $this->mid->get_daily_count_report_payment($bv, $tgl_awal, '');
            $this->data['csk'] = $this->mid->get_daily_count_kursi_payment($bv, $tgl_awal, '');
            // $this->data['cj'] = $this->mid->get_daily_jam_payment($bv, $tgl_awal, '');
            $this->data['ch'] = $this->mid->get_daily_hari_payment($bv, $tgl_awal, '');
            $this->data['cd'] = $this->mid->get_daily_des_payment($bv, $tgl_awal, '');
            $this->data['cps'] = $this->mid->get_daily_pesan_payment($bv, $tgl_awal, '');
            $this->data['cby'] = $this->mid->get_daily_bayar_payment($bv, $tgl_awal, '');
            $this->data['cpa'] = $this->mid->get_daily_admin_payment($bv, $tgl_awal, '');
        } else {
            $this->data['cst'] = $this->mid->get_daily_count_report_payment($bv, $tgl_awal, $tgl_akhir);
            $this->data['csk'] = $this->mid->get_daily_count_kursi_payment($bv, $tgl_awal, $tgl_akhir);
            // $this->data['cj'] = $this->mid->get_daily_jam_payment($bv, $tgl_awal, $tgl_akhir);
            $this->data['ch'] = $this->mid->get_daily_hari_payment($bv, $tgl_awal, $tgl_akhir);
            $this->data['cd'] = $this->mid->get_daily_des_payment($bv, $tgl_awal, $tgl_akhir);
            $this->data['cps'] = $this->mid->get_daily_pesan_payment($bv, $tgl_awal, $tgl_akhir);
            $this->data['cby'] = $this->mid->get_daily_bayar_payment($bv, $tgl_awal, $tgl_akhir);
            $this->data['cpa'] = $this->mid->get_daily_admin_payment($bv, $tgl_awal, $tgl_akhir);
        }
        $this->db->order_by('date(waktu_berangkat)', 'desc');
        $this->load->view('rdpl/perjalanan/cetaklaporan_pembayaran', $this->data);
    }
}

/* End of file dashboard.php */
/* Location: ./application/controllers/rdpl/dashboard.php */
