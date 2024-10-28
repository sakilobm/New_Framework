<?php
${basename(__FILE__, '.php')} = function () {
    if (!Ads::isAdExist(1) || !Ads::isAdExist(2)) {
        if (isset($_POST['ad_code']) && isset($_POST['ad_type'])) {
            $ad_code = $_POST['ad_code'];
            $description = $_POST['description'];
            $ad_type = $_POST['ad_type'];

            $result = Ads::add($ad_code, $description);

            if (!$result) {
                $this->response($this->json([
                    'message' => "Something went Wrong ! When Create Ad. Please Try Again"
                ]), 400);
            } else {
                if ($ad_type == 'ads_txt') {
                    if (Ads::addToAdsTxt()) {
                        $this->response($this->json([
                            'message' => "Successfully Ad Added To The (ads.txt) File"
                        ]), 200);
                    }
                }

                $this->response($this->json([
                    'message' => "New Ad Has Been Added"
                ]), 200);
            }
        } else {
            $this->response($this->json([
                'message' => "Bad Request"
            ]), 419);
        }
    } else {
        $this->response($this->json([
            'message' => "You Have Reached The Limit Of 2 Ads. You Cannot Add Any More Ads."
        ]), 400);
    }
};
