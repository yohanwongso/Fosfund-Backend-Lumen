<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    private function getAdminID () {
        $userID = Auth::id();

        $result = DB::select('
            SELECT `id`
            FROM `admin`
            WHERE `user_id` = ?;
        ', [$userID]);

        return (int)$result[0]->id;
    }

    public function verifPembayaran($order_id) {
        $adminID = $this->getAdminID();

        DB::beginTransaction();
        $result = DB::update('
            UPDATE `order`
            SET `admin_verifier_pembayaran_id` = ?, `waktu_verif_pembayaran` = CURRENT_TIMESTAMP
            WHERE `id` = ? AND `bukti_bayar_doc_path` != NULL;
        ', [$adminID, $order_id]);

        if ($result) {
            DB::commit();
            return response()->json([
                'success' => true,
                'data' => $result
            ],200);
        } else {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'data' => ''
            ],400);
        }
    }

    public function verifSekolah($sekolah_id) {
        $adminID = $this->getAdminID();

        DB::beginTransaction();
        $result = DB::update('
            UPDATE `sekolah`
            SET `admin_verifier_id` = ?, `waktu_verif` = CURRENT_TIMESTAMP
            WHERE `id` = ?;
        ', [$adminID, $sekolah_id]);

        if ($result) {
            DB::commit();
            return response()->json([
                'success' => true,
                'data' => $result
            ],200);
        } else {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'data' => ''
            ],400);
        }
    }

    public function verifPengajuanAA($pengajuan_aa_id) {
        $adminID = $this->getAdminID();

        DB::beginTransaction();
        $result = DB::update('
            UPDATE `pengajuan_anak_asuh`
            SET  `admin_verifier_id` = ?, `waktu_verif` = CURRENT_TIMESTAMP
            WHERE `id` = ? AND `form_doc_path` != NULL;
        ', [$adminID, $pengajuan_aa_id]);

        if ($result) {
            DB::commit();
            return response()->json([
                'success' => true,
                'data' => $result
            ],200);
        } else {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'data' => ''
            ],400);
        }
    }

    public function getMatchedData() {

    }
}
