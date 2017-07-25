<div class="box-col">
    <button class='export-pdf k-button'>Export as PDF</button>
</div>
<script>
    // Import DejaVu Sans font for embedding

    // NOTE: Only required if the Kendo UI stylesheets are loaded
    // from a different origin, e.g. cdn.kendostatic.com
    kendo.pdf.defineFont({
        "DejaVu Sans"             : "https://kendo.cdn.telerik.com/2016.2.607/styles/fonts/DejaVu/DejaVuSans.ttf",
        "DejaVu Sans|Bold"        : "https://kendo.cdn.telerik.com/2016.2.607/styles/fonts/DejaVu/DejaVuSans-Bold.ttf",
        "DejaVu Sans|Bold|Italic" : "https://kendo.cdn.telerik.com/2016.2.607/styles/fonts/DejaVu/DejaVuSans-Oblique.ttf",
        "DejaVu Sans|Italic"      : "https://kendo.cdn.telerik.com/2016.2.607/styles/fonts/DejaVu/DejaVuSans-Oblique.ttf",
        "WebComponentsIcons"      : "https://kendo.cdn.telerik.com/2017.1.223/styles/fonts/glyphs/WebComponentsIcons.ttf"
    });
</script>
<!-- Load Pako ZLIB library to enable PDF compression -->
<script src="https://kendo.cdn.telerik.com/2017.2.504/js/pako_deflate.min.js"></script>

<script>
$(document).ready(function() {
    $(".export-pdf").click(function() {
        // Convert the DOM element to a drawing using kendo.drawing.drawDOM
        kendo.drawing.drawDOM($(".content-wrapper"))
            .then(function(group) {
                // Render the result as a PDF file
                return kendo.drawing.exportPDF(group, {
                    paperSize: "auto",
                    margin: { left: "1cm", top: "1cm", right: "1cm", bottom: "1cm" }
                });
            })
            .done(function(data) {
                // Save the PDF file
                kendo.saveAs({
                    dataURI: data,
                    fileName: "HR-Dashboard.pdf",
                    proxyURL: "https://demos.telerik.com/kendo-ui/service/export"
                });
            });
    });
});
</script>
    <?php if ($records != false) { ?>
<div class="demo-section content-wrapper wide">
        <?php $row2=$records->row();
        echo '<h1>Travel destination: '.$row2->cityName.'</h1>';
        ?>
        <?php foreach ($records->result() as $row) { ?>
            <h1>Day <?php echo $row->dayOrder; ?></h1>
            <ul class="list-group">
                <p>selected attractions</p>
                <?php
                $this->load->model('TravelPlanning_model');
                $query = $this->TravelPlanning_model->getAllSelectedAttraction($row->dayId);
                if ($query != false) {
                    foreach ($query->result() as $row1) {
                        ?>
                        <li class="list-group-item"><img src="<?php echo $row1->image; ?>" height="100" width="100"><a href="<?php echo site_url('travelAttraction/showAttraction/'.$row1->attraction_id);?>"><?php echo $row1->placeName; ?></a>
                            <p>arrival time: </p><?php echo $row1->time; ?></li>
                    <?php }
                } ?>
            </ul>
            <div class="form-group">
                <label for="note">Note:</label>
                <textarea class="form-control" rows="5" id="note" readonly><?php echo $row->note; ?></textarea>
            </div>
        <?php } ?>
</div>
    <?php } ?>
