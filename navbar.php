<!DOCTYPE html>
<html>
<head>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">

</head>
<body>
    <ul class="nav nav-pills mb-3 my-2 mx-2" id="pills-tab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="Home-tab" data-toggle="pill" href="Home" role="tab" aria-controls="pills-home" aria-selected="true">Home</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="Credit-tab" data-toggle="pill" href="Credit" role="tab" aria-controls="pills-profile" aria-selected="false">Credit</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="Statistieken-tab" data-toggle="pill" href="Statistieken" role="tab" aria-controls="pills-contact" aria-selected="false">Statistieken</a>
        </li>
    </ul>
    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="Home-tab">Home</div>
        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="Credit-tab">Credit</div>
        <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="Statistieken-tab">Statistieken</div>
    </div>
    

</body>
</html>