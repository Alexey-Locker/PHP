<!DOCTYPE html>
<html lang="en">

<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Header</title>
</head>

<body>
        <style>
                body {
                        overflow-x: hidden;
                }

                .wrapper {
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        height: 100vh;
                }

                form {
                        margin-top: 15px;
                }

                input {
                        border: 1px solid black;
                        padding: 10px 5px;
                        background-color: white;
                        margin-right: 10px;
                }

                .file {
                        position: inherit;
                }

                .file__button {
                        width: 0.1px;
                        height: 0.1px;
                        opacity: 0;
                        overflow: hidden;
                        position: absolute;
                        z-index: -1;
                        margin: 0;
                }

                .upload {
                        display: block;
                        margin:0;
                        font: 400 13.3333px Arial;
                        z-index: 100;
                        border: 1px solid black;
                        padding: 10px 5px;
                        margin-right: 10px;

                }
                .upload-active{
                        font-size:10.3333px;
                        padding: 12px 5px;
                        max-width: 129.77px;
                }
                .upload__name-file{
                        font: 400 10.3333px Arial;
                }

                .wrapper__form {
                        display: flex;
                }

                .wrapper__form-uploading {
                        display: flex;
                }

        </style>
        <div class="wrapper">
                <div>
                        Please upload the file format as: "csv"<br><br>
                        <form class="wrapper__form-uploading" action="../controler/controler.php" method="POST" enctype="multipart/form-data">


                                <label class="file">
                                        <input type="file" name="userfile" class="file__button">
                                        <p class="upload">Uploading File</p>
                                </label>
                                <input type="submit" disabled value="Submit" id="submit">
                        </form>
                        <div class="wrapper__form">
                                <form action="table.php">
                                        <input type="submit" value="View results">
                                </form>

                                <form method="POST" action="../controler/clear.php">
                                        <input type="submit" value="Clear all records" name="clearDB">
                                </form>
                        </div>


                </div>

                <?php
                if ($_GET["base"] === "true") {
                ?>
                        <div>
                                <p style="background-color:green; padding:10px; color:white">File accepted and database processed the request</p>
                        </div>
                <?php
                } else if ($_GET["base"] === "false") {
                ?>
                        <div>
                                <p style="background-color:red; padding:10px; color:white">The data in the uploaded file does not match the form</p>
                        <?php
                }
                if ($_GET["clear"] === "true") {
                        ?>
                                <div>
                                        <p style="background-color:red; padding:10px; color:white">Database Clear</p>
                                </div>
                        <?php
                }
                        ?>
                        </div>

                        <script>
                                /// Валидация файла.
                                var file = document.querySelector(".file__button");
                                var submit = document.getElementById("submit");
                                var upload = document.querySelector(".upload");
                                file.addEventListener("change", () => {
                                        var reg = /.(\.csv)$/;
                                        var value;

                                        (file.files.length === 0) ? value = null: value = file.files[0].name;

                                        if (reg.test(value)) {
                                                submit.removeAttribute("disabled");
                                                upload.classList.toggle("upload-active");
                                                upload.innerHTML = 'Uploading File:' + `<span class = 'upload__name-file'>${value}</span>`;

                                        } else {
                                                submit.setAttribute("disabled", "true");
                                                upload.innerHTML = 'Uploading File';

                                        }
                                })
                        </script>
</body>

</html>