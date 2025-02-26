<?php
#region include files
// Include the database connection file
include('includes/db_connect.php');
// Include the header file
include('includes/header.php');
#endregion
?>




<!-- #region body -->
    <div class="p-5 mb-auto">
        <h2>Document Repository</h2>
        <form action="helpers/document_repository_upload.php" method="post" enctype="multipart/form-data" class="row text-bg-dark d-flex justify-content-center align-items-center my-5" style="height: 300px;">
            <div class="col-4">
                <input type="file" class="form-control tbox col-4" name="file" id="file" required>
            </div>
            <div class="col-2">
                <button type="submit" class="btn btn-primary">Upload</button>
            </div>
        </form>
        <?php
            $result = $conn->query("SELECT * FROM files ORDER BY uploaded_at DESC");

            if ($result->num_rows > 0) {
                echo "<h3>Saved Documents:</h3>";
                echo "<div class='container mt-4'>
                        <div class='row gy-3'>"; // Adds spacing between rows

                while ($row = $result->fetch_assoc()) {
                    $filePath = $row['file_path'];
                    $fileName = htmlspecialchars($row['file_name']);

                    echo "<div class='col-md-4'>  <!-- three-column layout -->
                            <div class='card shadow-sm p-3 border-0 text-bg-dark h-100 d-flex align-items-center text-center'>
                                <i class='bi bi-file-earmark-pdf-fill text-danger' style='font-size: 3rem;'></i>
                                <h6 class='mt-2'>$fileName</h6>
                                <a class='btn btn-primary mt-2' href='view_pdf.php?file=" . urlencode($filePath) . "' target='_blank'>
                                    View PDF
                                </a>
                            </div>
                        </div>";
                }
                echo "</div></div>"; // Close row and container
            } else {
                echo "No documents uploaded yet.";
            }   
        ?>
    </div>
<!-- #endregion -->




<!-- #region footer -->
    <?php
    // Include the footer file
    include('includes/footer.php');
    ?>

    <script>
    // Activate the sidebar link
    document.getElementById("sidebarDocs").classList.add("active");
    </script>
<!-- #endregion -->