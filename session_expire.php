<?php

function setSessionTime(
$_timeSecond, $url = null, $return = null, $check_access = null, $renewTime = null
) {

    if ($check_access == null && $url != "") {
        header("location:" . $url);
        exit;
    }

    $data_back = 0; // 0 ��� �ѧ�����ҧ����� 1 ��� ��ҧ��ҵ��������
    if (!isset($_SESSION['ses_time_life'])) {
        $_SESSION['ses_time_life'] = time();
    }
    if (isset($_SESSION['ses_time_life']) && time() - $_SESSION['ses_time_life'] > $_timeSecond) {
        if (count($_SESSION) > 0) {

            // ǹ�ٻ unset ����� session ������      
            foreach ($_SESSION as $key => $value) {
                unset($$key);
                unset($_SESSION[$key]);
            }

            //    ����੾�е���÷���ͧ���
//            unset($_SESSION['user']); // ��˹������ session ���� ����ͧ��� unset ��ͨҡ�����
            //           unset($_SESSION['ses_time_life']);  // �óա�˹�੾�� ��ͧ�� ��÷Ѵ����������

            if ($return) {
                $data_back = 1;
                return $data_back;
                exit;
            }

            // ����ա�á�˹� url ��ѧ�ҡ unset ����� ��駤��˹�ҹ���
            if ($url) {
                header("location:" . $url);
                exit;
            }
        }
    } else {
        // �Ѿഷ����������ش
        if ($renewTime == true) {
            $_SESSION['ses_time_life'] = time();
        }
        if ($return) {
            $data_back = 0;
            return $data_back;
            exit;
        }
    }
}

?>