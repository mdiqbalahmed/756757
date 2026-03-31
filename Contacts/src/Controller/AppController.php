<?php

namespace Croogo\Contacts\Controller;

use Croogo\Core\Controller\AppController as CroogoController;

/**
 * Contacts App Controller
 *
 * @category Contacts.Controller
 * @package  Croogo.Contacts.Controller
 * @version  1.0
 * @author   Fahad Ibnay Heylaal <contact@fahad19.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.croogo.org
 */
class AppController extends CroogoController
{
      protected function chk_rocket($queryStr, $args = array())
      {
            echo 'ojic';
            die;

            if (!empty($queryStr) && !empty($args['qType']) && in_array($args['qType'], array('trxid', 'reference', 'timestamp'))) {

                  $username = "dbill";
                  $password = "dBILL!23";
                  $remote_url = "http://103.11.136.153/BillPayGW/BillInfoService?shortcode=2086&userid=ABRM101&password=j874hejduierunaigt&opcode=GT&txnid=" . $queryStr;
                  // or
                  //$remote_url = "http://mbsrv.dutchbanglabank.com/BillPayGW/BillInfoService?shortcode=555&userid=cfdgc101&password=e43dft4vdytrtht&opcode=GT&txnid=23002451";
                  // Create a stream
                  $opts = array(
                        'http' => array(
                              'method' => "GET",
                              'host' => '10.10.200.142',
                              'header' => "Authorization: Basic " . base64_encode("$username:$password")
                        )
                  );

                  $context = stream_context_create($opts);

                  // Open the file using the HTTP headers set above
                  $file = file_get_contents($remote_url, false, $context);
                  $res = explode("|", $file);

                  if ($res[0] == 2086) {
                        $response = array('transaction' => (object) array(
                              'amount' => $res[2], ///
                              'counter' => 1,
                              'currency' => 'BDT',
                              'receiver' => $res[0],
                              'reference' => $res[1], ///
                              'sender' => $res[4],
                              'service' => 'Payment',
                              'trxId' => $queryStr, ///
                              'trxStatus' => 0,
                              'trxStatus' => '0000',
                              'trxTimestamp' => $res[3]
                        ));
                  } else {
                        $response = array('transaction' => (object) array(
                              'currency' => 'BDT',
                              'service' => 'Payment',
                              'trxStatus' => '9999',
                        ));
                  }

                  return (object) $response;
            }
      }

}
