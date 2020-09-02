<!DOCTYPE html>
<html>

<head>
  <title>Laravel</title>

  <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

  <style>

  </style>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" />
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</head>

<body>
  <div class="container">
    <div class="col-md-6 mx-auto text-center">
      <div class="header-title">
        <h1 class="wv-heading--title">
          Test Form BBL
        </h1>

      </div>
    </div>
    <div class="row">
      <div class="col-md-12 mx-auto">
        <div class="myform form ">
          <form method="post" action="http://192.168.99.117:8002/payment/gateway/bbl/form">

            <?php
            $data = [
              'orderRef' => '1000',
              'successCallback' => 'http://192.168.99.117:800',
              'failCallback' => 'http://192.168.99.117:800',
              'brandIdentifier' => 'TTC',
              'productIdentifier' => 'insurunce'
            ];
            ?>

            <?php
            foreach ($data as $k => $v) {
            ?>
              <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="<?= $k ?>"><?= $k ?></label>
                <div class="col-sm-10">
                  <input type="text" class="form-control form-control-sm" name="<?= $k ?>" id="<?= $k ?>" value="<?= $v ?>" />
                </div>
              </div>
            <?php } ?>
            <button type="submit" class="btn btn-primary">Submit</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</body>

</html>