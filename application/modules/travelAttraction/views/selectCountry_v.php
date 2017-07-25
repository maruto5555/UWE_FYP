<div class="row">
    <div class="col-lg-6">
        <div class="input-group">
            <input type="text" class="form-control" id="search" name="inputSearch" placeholder="search attractions"
                   required>
            <span class="input-group-btn">
    <button type="submit" id="submit" class="btn btn-default">Search</button>
          </span>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <div class="example">
            <div class="demo-section k-content">
                <ul id="menu">
                    <?php foreach ($records->result() as $row){ ?>
                    <li><?php echo $row->countryName; ?>

                        <?php
                        $query = $this->TravelAttraction_model->getCity($row->countryId);
                        if ($query != false) {
                            ?>
                            <ul>
                                <?php
                                foreach ($query->result() as $row1) {
                                    ?>
                                    <li name="selectCity"
                                        id="<?php echo $row1->cityId; ?>"><?php echo $row1->cityName; ?></li>
                                <?php } ?>
                            </ul>
                            <?php
                        }
                        } ?>

                    </li>
                </ul>
            </div>
        </div>

    </div>

    <div class="col-md-8">

        <div id="example">

            <div class="demo-section k-content wide">
                <div id="listView"></div>
                <div id="pager" class="k-pager-wrap"></div>
            </div>

            <script type="text/x-kendo-template" id="template">
                <div class="product">
                    <a href="<?php echo site_url('travelAttraction/showAttraction/#: taId #'); ?>" target="_blank"> <img
                                src="#: image #" alt="#: placeName # image"/></a>
                    <h3>#:placeName#</h3>
                </div>
            </script>

            <script>
                $(function () {
                    $("#submit").click(function () {
                        var keyword = $("#search").val();
                        var dataSource = new kendo.data.DataSource({ //reset data source
                            transport: {
                                read: {
                                    url: "<?php echo site_url('travelAttraction/allAttractionJSON');?>",
                                    dataType: "json",
                                    type: "get",
                                    data: {
                                        keyword: keyword
                                    }
                                }
                            },
                            pageSize: 10
                        });
                        setListView(dataSource);
                    });

                    $("[name=selectCity]").click(function () {
                        var dataSource = new kendo.data.DataSource({ //reset data source
                            transport: {
                                read: {
                                    url: "<?php echo site_url('travelAttraction/allAttractionJSON');?>",
                                    dataType: "json",
                                    type: "get",
                                    data: {
                                        cityId: $(this).attr('id')
                                    }
                                }
                            },
                            pageSize: 10
                        });
                        setListView(dataSource);
                    });

                    var dataSource = new kendo.data.DataSource({
                        transport: {
                            read: {
                                url: "<?php echo site_url('travelAttraction/allAttractionJSON');?>",
                                dataType: "json"
                            }
                        },
                        pageSize: 10
                    });
                    var setListView = function (dataSource) {
                        $("#pager").kendoPager({
                            dataSource: dataSource
                        });
                        $("#listView").kendoListView({
                            dataSource: dataSource,
                            template: kendo.template($("#template").html())
                        });
                    };
                    setListView(dataSource);
                    var initMenu = function () {
                        $("#menu").kendoMenu({
                            orientation: 'vertical'
                        });
                    };
                    initMenu();
                });
            </script>
            <style>
                #listView {
                    padding: 10px 5px;
                    margin-bottom: -1px;
                    min-height: 310px;
                }

                .product {
                    float: left;
                    position: relative;
                    width: 111px;
                    height: 500px;
                    margin-right: 150px;
                    padding: 0;
                }

                .product img {
                    width: 210px;
                    height: 210px;
                }

                .product h3 {
                    margin: 0;
                    padding: 3px 5px 0 0;
                    max-width: 96px;
                    overflow: hidden;
                    line-height: 1.1em;
                    font-size: .9em;
                    font-weight: normal;
                    text-transform: uppercase;
                    color: #999;
                }

                .product p {
                    visibility: hidden;
                }

                .product:hover p {
                    visibility: visible;
                    position: absolute;
                    width: 210px;
                    height: 110px;
                    top: 0;
                    margin: 0;
                    padding: 0;
                    line-height: 310px;
                    vertical-align: middle;
                    text-align: center;
                    color: #fff;
                    background-color: rgba(0, 0, 0, 0.75);
                    transition: background .2s linear, color .2s linear;
                    -moz-transition: background .2s linear, color .2s linear;
                    -webkit-transition: background .2s linear, color .2s linear;
                    -o-transition: background .2s linear, color .2s linear;
                }

                .k-listview:after {
                    content: ".";
                    display: block;
                    height: 0;
                    clear: both;
                    visibility: hidden;
                }
            </style>
        </div>
    </div>
</div>

