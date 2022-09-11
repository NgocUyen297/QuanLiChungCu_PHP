@extends('homelayouts')

@section('head')

<?php
    use App\Models\HopDong;
    use App\Models\ThongTinCanHo;
    use App\Models\ThongTinHoaDon;
    use App\Models\NhanKhau;
    use App\Models\ThongTinHo;
    use App\Models\ThongTinSuCo;
    use App\Models\HoaDon;
    use App\Models\NhanVien;
    use App\Models\DoiTac;
    use App\Models\QuyDinh;
?>
<script>

    var table;
    var labels;  //array
    var values = new Array();   //2D array
    var alert;
    <?php
        if ($_SERVER['REQUEST_METHOD'] == 'GET')
        {
            echo "
                let params = new URLSearchParams((new URL(window.location.href)).search);
                var tableIndex = params.get('tab-selection');
            ";
        }
        else {
            echo "var tableIndex = '{$tabSelection}';";
        }
    ?>
    
    var tableNameForManager = new Array('hopdong', 'thongtincanho', 'nhankhau', 'thongtinsuco');
    var tableNameForAccountant = new Array('hoadon_kh', 'hoadon_dt');

    window.onload = function() {
        @if (auth()->user()->Role == 'Manager') 
        switch (tableIndex) {
            case '1':
                var liNodes = document.querySelectorAll('li.nav-item');
                liNodes.forEach(li => {
                    li.classList.remove('tab-selected');
                });
                liNodes[0].classList.add('tab-selected');

                var contentBlock = document.getElementsByClassName('content')[0];
                // contentBlock.innerHTML += '
                //     <div class="frame">
                //         <div class="frame__general">
                //             <div class="frame__general--number">
                //                 <h7>Apartment Numbers</h7>
                //                 <p>{{$tongCacCanHo}}</p>
                //             </div>
                //             <div class="frame__general--number">
                //                 <h7>Individuals Numbers</h7>
                //                 <p>{{$demNhanKhau}}</p>
                //             </div>
                //             <div class="frame__general--number">
                //                 <h7>Debt Bills Numbers</h7>
                //                 <p>{{$debtBill}}</p>
                //             </div>
                //             <div class="frame__general--number">
                //                 <h7>Exits Error Reports</h7>
                //                 <p>{{$reportCount}}</p>
                //             </div>
                //         </div>
                        
                //         <div class="frame__average">
                //             <div class="frame__average--chart">
                //             <canvas id="myChartRevenue" width="50%" height="50%"></canvas>
                //             <p class="label-forChart">Revenue Statistics in 2022</p>
                //             </div>

                //             <!-- circle chart -->
                //             <div class="frame__average--circle-chart">
                //             <canvas id="myChartElectricity" width="50%" height="50%"></canvas>
                //             <p class="label-forChart">Electricity</p>
                //             <canvas id="myChartWater" width="50%" height="50%"></canvas>
                //             <p class="label-forChart">Water</p>
                //             </div>
                //         </div>
                //     </div>';

                break;
            case '2':
                AddSearchBarAndAddButton(table, 2);

                //Update Add Button
                tdAdd = document.getElementById('add-button');
                tdAdd.setAttribute('onclick', 'table.Add(\''+ 
                @if (auth()->user()->Role == "Manager")
                    tableNameForManager[tableIndex - 2]
                @else tableNameForAccountant[tableIndex - 3]
                @endif +'\')');


                var liNodes = document.querySelectorAll('li.nav-item');
                liNodes.forEach(li => {
                    li.classList.remove('tab-selected');
                });
                liNodes[1].classList.add('tab-selected');

                // add labels
                labels = new Array('ID', 'Store Path', 'Date', 'Apartment No.', "Owner", 'Identity', 'Created By', 'Function');
                // add values
                var count = 0;
                @foreach ($table_results as $value)
                    values.push(new Array(
                        '{{$value->id}}',
                        '{{$value->path}}',
                        '{{$value->date}}'
                        @if ($value->thongTinCanHo != null)
                            ,'{{$value->thongTinCanHo->description}}'
                            <?php
                                $owner = ThongTinHo::where('apartmentNo', $value->thongTinCanHo->id)->first();
                            ?>
                            ,'{{$owner->ownerLastName}}' + ' ' + '{{$owner->ownerFirstName}}'
                            ,'{{$owner->ownerIdentityNumber}}'
                        @endif
                        @if ($value->NhanVien != null)
                            ,'{{$value->NhanVien->lastname}}' + ' ' +'{{$value->NhanVien->firstname}}'
                        @endif
                    ));
                    count++;
                @endforeach
                var extensions = [];
                @if ($extensions != null) {
                    @foreach ($extensions as $item)
                        extensions.push(new Array(
                            '{{$item->description}}',
                            '{{$item->id}}'
                        ));
                    @endforeach
                }
                @endif
                var listSelectBox = [];
                @if ($listSelect != null) {
                    @foreach ($listSelect as $item)
                        listSelectBox.push(new Array(
                            '{{$item->description}}',
                            '{{$item->id}}'
                        ));
                    @endforeach
                }
                @endif
                
                if (values.length == 0) {
                    table =  new TableLayouts(labels, [], 'contracts-table', document.getElementsByClassName('content')[0], {"View": true, "Update": true, "Delete": false, "Add": true}, null, [3], listSelectBox);
                    table.Init();
                    break;
                }
                table =  new TableLayouts(labels, values, 'contracts-table', document.getElementsByClassName('content')[0], {"View": true, "Update": true, "Delete": false, "Add": true}, null, [3], listSelectBox, extensions);
                table.Init()
                break;
            case '3':
                AddSearchBarAndAddButton(table, 3);

                //Update Add Button
                tdAdd = document.getElementById('add-button');
                tdAdd.setAttribute('onclick', 'table.Add(\''+ 
                @if (auth()->user()->Role == "Manager")
                    tableNameForManager[tableIndex - 2]
                @else tableNameForAccountant[tableIndex - 3]
                @endif +'\')');


                var liNodes = document.querySelectorAll('li.nav-item');
                liNodes.forEach(li => {
                    li.classList.remove('tab-selected');
                });
                liNodes[2].classList.add('tab-selected');

                // add labels
                labels = new Array('ID', 'Description', 'Rooms', 'Upstairs', 'Restroom', 'In Area', 'Created By', 'Function');
                // add values
                var count = 0;
                @foreach ($table_results as $value)
                    values.push(new Array(
                        '{{$value->id}}',
                        '{{$value->description}}',
                        '{{$value->rooms}}',
                        '{{$value->upstairs}}',
                        '{{$value->restroom}}',
                        '{{$value->inArea}}'
                        @if ($value->NhanVien != null)
                            ,'{{$value->NhanVien->lastname}}' + ' ' +'{{$value->NhanVien->firstname}}'
                        @endif
                    ));
                    count++;
                @endforeach
                @if ($alert != null)
                    alert = new Array();
                    @foreach ($alert as $item)
                        alert.push({{$item->id}});
                    @endforeach
                @endif
                
                if (values.length == 0) {
                    var notice = document.createTextNode("No items for viewing.")
                    document.getElementsByClassName('content')[0].appendChild(notice);
                    break;
                }
                table =  new TableLayouts(labels, values, 'apartment-table', document.getElementsByClassName('content')[0], {"View": true, "Update": true, "Delete": false, "Add": true}, alert);
                table.Init()
                break;
            case '4':
                AddSearchBarAndAddButton(table, 4);

                //Update Add Button
                tdAdd = document.getElementById('add-button');
                tdAdd.setAttribute('onclick', 'table.Add(\''+ 
                @if (auth()->user()->Role == "Manager")
                    tableNameForManager[tableIndex - 2]
                @else tableNameForAccountant[tableIndex - 3]
                @endif +'\')');


                var liNodes = document.querySelectorAll('li.nav-item');
                liNodes.forEach(li => {
                    li.classList.remove('tab-selected');
                });
                liNodes[3].classList.add('tab-selected');

                // add labels
                labels = new Array('ID', 'Name', 'Identity Number', 'Ap. Owner', 'Function');
                // add values
                var count = 0;
                @foreach ($table_results as $value)
                    values.push(new Array(
                        '{{$value->id}}',
                        '{{$value->lastname}}' + ' ' + '{{$value->firstname}}',
                        '{{$value->identityNumber}}'
                        @if ($value->thongTinHo != null)
                            ,'{{$value->thongTinHo->ownerLastName}}' + ' ' + '{{$value->thongTinHo->ownerFirstName}}'
                        @endif
                    ));
                    count++;
                @endforeach
                @if ($alert != null)
                    alert = new Array();
                    @foreach ($alert as $item)
                        alert.push({{$item->id}});
                    @endforeach
                @endif
                var listSelectBox = [];
                @if ($listSelect != null) {
                    @foreach ($listSelect as $item)
                        listSelectBox.push(new Array(
                            '{{$item->ownerLastName}}' + ' ' + '{{$item->ownerFirstName}}' + '     @id=' + '{{$item->ownerIdentityNumber}}',
                            '{{$item->id}}'
                        ));
                    @endforeach
                }
                @endif

                
                if (values.length == 0) {
                    var notice = document.createTextNode("No items for viewing.")
                    document.getElementsByClassName('content')[0].appendChild(notice);
                    break;
                }
                table =  new TableLayouts(labels, values, 'individuals-table', document.getElementsByClassName('content')[0], {"View": true, "Update": true, "Delete": true, "Add": true}, alert, [3], listSelectBox);
                table.Init()
                break;
            case '5':
                AddSearchBarAndAddButton(table, 5);

                //Update Add Button
                tdAdd = document.getElementById('add-button');
                tdAdd.setAttribute('onclick', 'table.Add(\''+ 
                @if (auth()->user()->Role == "Manager")
                    tableNameForManager[tableIndex - 2]
                @else tableNameForAccountant[tableIndex - 3]
                @endif +'\')');


                var liNodes = document.querySelectorAll('li.nav-item');
                liNodes.forEach(li => {
                    li.classList.remove('tab-selected');
                });
                liNodes[4].classList.add('tab-selected');

                // add labels
                labels = new Array('ID', 'Description', 'Date', 'Apartment No.', 'Created By', 'Function');
                // add values
                var count = 0;
                @foreach ($table_results as $value)
                    values.push(new Array(
                        '{{$value->id}}',
                        '{{$value->description}}',
                        '{{$value->date}}'
                        @if ($value->thongTinCanHo != null)
                            ,'{{$value->thongTinCanHo->description}}'
                        @endif
                        @if ($value->NhanVien != null)
                            ,'{{$value->NhanVien->lastname}}' + ' ' +'{{$value->NhanVien->firstname}}'
                        @endif
                    ));
                    count++;
                @endforeach
                var listSelectBox = [];
                @if ($listSelect != null)
                    @foreach ($listSelect as $item)
                        listSelectBox.push(new Array(
                            '{{$item->description}}',
                            '{{$item->id}}'
                        ));
                    @endforeach
                @endif
                @if ($alert != null)
                    alert = new Array();
                    @foreach ($alert as $item)
                        alert.push({{$item->id}});
                    @endforeach
                @endif
                
                if (values.length == 0) {
                    table =  new TableLayouts(labels, [], 'contracts-table', document.getElementsByClassName('content')[0], {"View": true, "Update": true, "Delete": true, "Add": true}, null, [3], listSelectBox);
                    table.Init();
                    break;
                }
                table =  new TableLayouts(labels, values, 'report-table', document.getElementsByClassName('content')[0], {"View": true, "Update": true, "Delete": false, "Add": true}, alert, [3], listSelectBox);
                table.Init()
                break;
            @else
            switch (tableIndex) {
                case '1':
                    var liNodes = document.querySelectorAll('li.nav-item');
                    liNodes.forEach(li => {
                        li.classList.remove('tab-selected');
                    });
                    liNodes[0].classList.add('tab-selected');
                    break;
                case '2':
                    var liNodes = document.querySelectorAll('li.nav-item');
                    liNodes.forEach(li => {
                        li.classList.remove('tab-selected');
                    });
                    liNodes[1].classList.add('tab-selected');
                    break;
                case '3':
                    AddSearchBarAndAddButton(table, 3);

                    //Update Add Button
                    tdAdd = document.getElementById('add-button');
                    tdAdd.setAttribute('onclick', 'table.Add(\''+ 
                    @if (auth()->user()->Role == "Manager")
                        tableNameForManager[tableIndex - 2]
                    @else tableNameForAccountant[tableIndex - 3]
                    @endif +'\')');


                    var liNodes = document.querySelectorAll('li.nav-item');
                    liNodes.forEach(li => {
                        li.classList.remove('tab-selected');
                    });
                    liNodes[2].classList.add('tab-selected');

                    // add labels
                    labels = new Array('ID', 'Description', "Date", 'Who Pay', 'Created By', 'Elec', 'Water', "Net", "Error", 'Sum', "Paid", 'Function');
                    // add values
                    var count = 0;
                    @foreach ($table_results as $value)
                        values.push(new Array(
                            '{{$value->id}}',
                            '{{$value->description}}',
                            '{{$value->createdDate}}'
                            @if ($value->whoPay != null)
                                ,
                                "<?php
                                    $valueWhoPay = ThongTinHo::where('id', $value->whoPay)->first();
                                    if ($valueWhoPay) {
                                        echo "{$valueWhoPay->ownerLastName}" . " " . "{$valueWhoPay->ownerFirstName}";
                                    }
                                    else echo "";
                                ?>"
                            @else
                                ,""
                            @endif
                            @if ($value->nhanVien != null)
                                ,'{{$value->nhanVien->lastname}}' + ' ' + '{{$value->nhanVien->firstname}}'
                            @endif
                            <?php 
                                $tthoadon = ThongTinHoaDon::where('linkId', $value->id)->first();
                            ?>
                            @if ($tthoadon != null)
                                ,"{{number_format($tthoadon->electricity, 0, ',', '.')}}"
                                ,"{{number_format($tthoadon->water, 0, ',', '.')}}"
                                ,"{{number_format($tthoadon->internet, 0, ',', '.')}}"
                                ,"{{number_format($tthoadon->error, 0, ',', '.')}}"
                                <?php
                                    $reg = QuyDinh::where('id', $value->regulationId)->get();
                                    $regulation = [];
                                    $electronicFee = $waterFee = $internetFee = 1;
                                    foreach ($reg as $r) {
                                        $electronicFee = $r->electronicFee;
                                        $waterFee = $r->waterFee;
                                        $internetFee = $r->internetFee;
                                    }
                                    $sum = ($tthoadon->electricity ? $tthoadon->electricity : 0) * $electronicFee + 
                                        ($tthoadon->water ? $tthoadon->water : 0) * $waterFee  + 
                                        ($tthoadon->internet ? $tthoadon->internet : 0) * $internetFee  + 
                                        ($tthoadon->error ? $tthoadon->error : 0);
                                ?>
                                ,"{{number_format($sum, 0, ',', '.')}}"
                                ,"{{$tthoadon->paid}}"
                            @endif
                        ));
                        count++;
                    @endforeach

                    var alert = [];
                    @if ($alert != null) 
                        @foreach ($alert as $item)
                            alert.push({{$item->linkId}});
                        @endforeach
                    @endif

                    var listSelectBox = [];
                    @if ($listSelect != null)
                        @foreach ($listSelect as $item)
                            listSelectBox.push(new Array(
                                '{{$item->ownerLastName}}' + ' ' + '{{$item->ownerFirstName}}' + '     @ap=' +  
                                @if (ThongTinCanHo::where('id', $item->apartmentNo)->first() != null)
                                    '{{ThongTinCanHo::where('id', $item->apartmentNo)->first()->description}}'
                                @else ""
                                @endif
                                ,'{{$item->id}}'
                            ));
                        @endforeach
                    @endif
                    
                    if (values.length == 0) {
                        var notice = document.createTextNode("No items for viewing.")
                        document.getElementsByClassName('content')[0].appendChild(notice);
                        break;
                    }
                    table =  new TableLayouts(labels, values, 'bills-customer-table', document.getElementsByClassName('content')[0], {"View": true, "Update": true, "Delete": true, "Add": true}, alert, [3], listSelectBox);
                    table.Init();
                    break;
                case '4':
                    AddSearchBarAndAddButton(table, 4);

                    //Update Add Button
                    tdAdd = document.getElementById('add-button');
                    tdAdd.setAttribute('onclick', 'table.Add(\''+ 
                    @if (auth()->user()->Role == "Manager")
                        tableNameForManager[tableIndex - 2]
                    @else tableNameForAccountant[tableIndex - 3]
                    @endif +'\')');

                    var liNodes = document.querySelectorAll('li.nav-item');
                    liNodes.forEach(li => {
                        li.classList.remove('tab-selected');
                    });
                    liNodes[3].classList.add('tab-selected');

                    // add labels
                    labels = new Array('ID', 'Description', "Date", 'Who Pay', 'Created By', 'Elec', 'Water', "Net", "Error", 'Sum', "Paid", 'Function');
                    // add values
                    var count = 0;
                    @foreach ($table_results as $value)
                        values.push(new Array(
                            '{{$value->id}}',
                            '{{$value->description}}',
                            '{{$value->createdDate}}'
                            @if ($value->whoPay != null)
                                ,
                                "<?php
                                    $valueWhoPay = DoiTac::where('id', $value->whoPay)->first();
                                    if ($valueWhoPay) {
                                        echo "{$valueWhoPay->companyName}";
                                    }
                                    else echo "";
                                ?>"
                            @else
                                ,""
                            @endif
                            @if ($value->nhanVien != null)
                                ,'{{$value->nhanVien->lastname}}' + ' ' + '{{$value->nhanVien->firstname}}'
                            @endif
                            <?php 
                                $tthoadon = ThongTinHoaDon::where('linkId', $value->id)->first();
                            ?>
                            @if ($tthoadon != null)
                                ,"{{number_format($tthoadon->electricity, 0, ',', '.')}}"
                                ,"{{number_format($tthoadon->water, 0, ',', '.')}}"
                                ,"{{number_format($tthoadon->internet, 0, ',', '.')}}"
                                ,"{{number_format($tthoadon->error, 0, ',', '.')}}"
                                <?php
                                    $sum = ($tthoadon->electricity ? $tthoadon->electricity : 0) + 
                                        ($tthoadon->water ? $tthoadon->water : 0) + 
                                        ($tthoadon->internet ? $tthoadon->internet : 0) + 
                                        ($tthoadon->error ? $tthoadon->error : 0);
                                ?>
                                ,"{{number_format($sum, 0, ',', '.')}}"
                                ,"{{$tthoadon->paid}}"
                            @endif
                        ));
                        count++;
                    @endforeach

                    var alert = [];
                    @if ($alert != null) 
                        @foreach ($alert as $item)
                            alert.push({{$item->linkId}});
                        @endforeach
                    @endif

                    var listSelectBox = [];
                    @if ($listSelect != null)
                        @foreach ($listSelect as $item)
                            listSelectBox.push(new Array(
                                '{{$item->companyName}}'
                                ,'{{$item->id}}'
                            ));
                        @endforeach
                    @endif
                    if (values.length == 0) {
                        var notice = document.createTextNode("No items for viewing.")
                        document.getElementsByClassName('content')[0].appendChild(notice);
                        break;
                    }
                    table =  new TableLayouts(labels, values, 'bills-partner-table', document.getElementsByClassName('content')[0], {"View": true, "Update": true, "Delete": true, "Add": true}, alert, [3], listSelectBox);
                    table.Init()
                    break;
            @endif
        }

        //Update Delete button
        @if (auth()->user()->Role == "Manager")
            var arrayUpdateDeleteFunc = ['2', '3', '4', '5'];
        @else var arrayUpdateDeleteFunc = ['3', '4'];
        @endif
        tdFunctions = document.getElementsByClassName('td-function');
        if (tdFunctions && arrayUpdateDeleteFunc.includes(tableIndex)) {
            for (var count = 0; count < tdFunctions.length; count++) {
                var obj = tdFunctions[count].lastChild.firstChild;
                try {
                    var id = obj.getAttribute('id').split('-');
                    obj.setAttribute('onclick', 'if (confirm("Are you sure to delete this?") == true) { SendUpdateRes(\'\/home\/delete\', "' + 
                        @if (auth()->user()->Role == "Manager")
                            tableNameForManager[tableIndex - 2]
                        @else tableNameForAccountant[tableIndex - 3]
                        @endif
                        + '", ' + parseInt(id[id.length - 1]) + '); table.Delete(' + parseInt(id[id.length - 1]) + '); } else { bs4Toast.error("Failed", "Action is not accepted."); }');    
                } catch (exeptions) {
                    continue;
                }
            };
        }

        //Update Edit Function
        tdFunctions = document.getElementsByClassName('td-function');
        @if (auth()->user()->Role == "Manager")
            var arrayUpdateEditFunc = ['2', '3', '4', '5'];
        @else var arrayUpdateEditFunc = ['3', '4'];
        @endif
        if (tdFunctions && arrayUpdateEditFunc.includes(tableIndex)) {
            for (var count = 0; count < tdFunctions.length; count++) {
                var obj = tdFunctions[count].childNodes[1].firstChild;
                try {
                    var id = obj.getAttribute('id').split('-');
                    obj.setAttribute('onclick', 'table.Update("' + 
                        @if (auth()->user()->Role == "Manager")
                            tableNameForManager[tableIndex - 2]
                        @else tableNameForAccountant[tableIndex - 3]
                        @endif + '", ' + parseInt(id[id.length - 1]) + ');');
                    obj.setAttribute('type', 'button');    
                } catch (exeptions) {
                    continue;
                }
            };
        }
        
    }

    function AddSearchBarAndAddButton(table, tableIndex) {
        var div = document.createElement('div');
        div.style.display = 'inline-block';
        div.setAttribute('id', 'top-of-table-bar');
        div.classList.add('col-md-12');
        var inputElement = document.createElement('input');
        inputElement.setAttribute('id', 'search-bar');
        inputElement.setAttribute('name', 'search-bar');
        inputElement.setAttribute('type', 'text');
        inputElement.setAttribute('value', '{{$contentSearch}}');
        inputElement.classList.add('col-md-2');
        var searchButton = document.createElement('button');
        searchButton.innerHTML += '<i class="fa-solid fa-magnifying-glass"></i>';
        searchButton.setAttribute('type', 'submit');
        searchButton.setAttribute('id', 'search-button');
        searchButton.style.width = "35px";
        searchButton.style.margin = "5px 5px 0 5px";
        searchButton.classList.add('button-table-bar');
        var addButton = document.createElement('button');
        addButton.innerHTML += '<i class="fa-solid fa-plus"></i>';
        addButton.setAttribute('type', 'button');
        addButton.setAttribute('id', 'add-button');
        addButton.style.width = "60px";
        addButton.style.margin = "5px 5px 0 5px";
        addButton.classList.add('button-table-bar');
        var formObject = document.createElement('form');
        formObject.setAttribute('action', '/home');
        formObject.setAttribute('method', 'post');
        formObject.innerHTML += '@csrf';
        var inputTableName = document.createElement('input');
        inputTableName.setAttribute('id', 'table-name');
        inputTableName.setAttribute('name', 'table-name');
        inputTableName.setAttribute('value', 
                        @if (auth()->user()->Role == "Manager")
                            tableNameForManager[tableIndex - 2]
                        @else tableNameForAccountant[tableIndex - 3]
                        @endif);
        inputTableName.style.visibility = 'hidden';
        inputTableName.style.position = 'absolute';
        var inputIndex = document.createElement('input');
        inputIndex.setAttribute('id', 'tab-selection');
        inputIndex.setAttribute('name', 'tab-selection');
        inputIndex.setAttribute('value', tableIndex);
        inputIndex.style.visibility = 'hidden';
        inputIndex.style.position = 'absolute';
        formObject.appendChild(searchButton);
        formObject.appendChild(inputElement);
        formObject.appendChild(inputTableName);
        formObject.appendChild(inputIndex);
        div.appendChild(formObject);
        div.appendChild(addButton);
        document.getElementsByClassName('content')[0].appendChild(div);
    }
    

    // var table = new TableLayouts();
    
    //Complete Function
    function Delete(id) {
        //process with interface
        table.Delete(id);
    }

    //Addition Function
    function SendUpdateRes(api, tableName, id) {
        const csrfToken = document.head.querySelector("[name~=csrf-token][content]").content;
        var tableNameUse = tableName;
        var vals = [];
        var count = 0;
        while (count <= 10) {
            var element = document.getElementById('input-value-' + count);
            if (element == null) {
                break;
            }
            if (element.value == "") {
                vals.push('null');
            } 
            else {
                vals.push(element.value);
            }
            count++;
        }

        fetch(api,
        {
            headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json; charset=UTF-8',
            "X-CSRF-Token": csrfToken
            },
            method: "POST",
            body: JSON.stringify({
                table: tableNameUse,
                val0: id,
                val1: vals[1],
                val2: vals[2],
                val3: vals[3],
                val4: vals[4],
                val5: vals[5],
                val6: vals[6],
                val7: vals[7],
                val8: vals[8],
                val9: vals[9],
                val10: vals[10]
            }), 
            data:{
                _token: "{{ csrf_token() }}"
            }
        })
        .then(function(res){ 
            if (res.status == 200) {
                bs4Toast.primary('Success', 'Action has been done.');
                setTimeout(function() {
                    window.location.reload();
                }, 2000);
            }
            else if (res.status == 500) {
                bs4Toast.error('Failed', 'Action is not accepted.');
                // setTimeout(function() {
                //     window.location.reload();
                // }, 2000);
            }
         });
    }
</script>
@endsection
@section('content')
    @if (auth()->user()->Role == 'Manager')	
    <div class="box_task">	
        <p class="box_task-heading">Task</p>	
        <p>Empty: <span>{{$empty}}</span></p>	
        <p>Report: {{$reportCount}}</p>	
        <p>Missed Individual: <span>{{$missedIndividualCount}}</span></p>	
        <p class="box_task-footer">Connected: 3</p>	
    </div>	
    @else	
    <div class="box_task" >	
        <p class="box_task-heading">Task</p>	
        <p>Customer Bills: {{$CustomerBillCount}}</p>	
        <p>Partner Bills: {{$partnetBillCount}}</p>	
    </div>	
    @endif

    @if (auth()->user()->Role == 'Manager' && $_REQUEST['tab-selection']== 1)
    <div class="frame">
        <div class="frame__general">
            <div class="frame__general--number">
                <h7>Apartment Numbers</h7>
                <p>{{$tongCacCanHo}}</p>
            </div>
            <div class="frame__general--number">
                <h7>Individuals Numbers</h7>
                <p>{{$demNhanKhau}}</p>
            </div>
            <div class="frame__general--number">
                <h7>Debt Bills Numbers</h7>
                <p>{{$debtBill}}</p>
            </div>
            <div class="frame__general--number">
                <h7>Exits Error Reports</h7>
                <p>{{$reportCount}}</p>
            </div>
        </div>
        
        <div class="frame__average">
            <div class="frame__average--chart">
            <canvas id="myChartRevenue" width="50%" height="50%"></canvas>
            <p class="label-forChart">Revenue Statistics in 2022</p>
            </div>

            <!-- circle chart -->
            <div class="frame__average--circle-chart">
            <canvas id="myChartElectricity" width="50%" height="50%"></canvas>
            <p class="label-forChart">Electricity</p>
            <canvas id="myChartWater" width="50%" height="50%"></canvas>
            <p class="label-forChart">Water</p>
            </div>
        </div>
    </div>
    @elseif ((auth()->user()->Role == 'Accountant' && $_REQUEST['tab-selection']== 1))
    <div class="frame">
        <div class="frame__general">
            <div class="frame__general--number">
                <h7>Apartment Numbers</h7>
                <p>{{$tongCacCanHo}}</p>
            </div>
            <div class="frame__general--number">
                <h7>Individuals Numbers</h7>
                <p>{{$demNhanKhau}}</p>
            </div>
            <div class="frame__general--number">
                <h7>Debt Bills Numbers</h7>
                <p>{{$debtBill}}</p>
            </div>
            <div class="frame__general--number">
                <h7>Exits Error Reports</h7>
                <p>{{$reportCount}}</p>
            </div>
        </div>
        
        <div class="frame__average">
            <div class="frame__average--chart">
            <canvas id="myChartRevenue" width="50%" height="50%"></canvas>
            <p class="label-forChart">Revenue Statistics in 2022</p>
            </div>

            <!-- circle chart -->
            <div class="frame__average--circle-chart">
            <canvas id="myChartElectricity" width="50%" height="50%"></canvas>
            <p class="label-forChart">Electricity</p>
            <canvas id="myChartWater" width="50%" height="50%"></canvas>
            <p class="label-forChart">Water</p>
            </div>
        </div>
    </div>
    @endif
    @if ((auth()->user()->Role == 'Accountant' && $_REQUEST['tab-selection']== 2))
            <div class="chart--usage">
              <canvas id="chart--usage-celetricity" width="25%" height="25%"></canvas>
              <canvas id="chart--usage-water" width="25%" height="25%"></canvas>
            </div>
              <div class="chart-inoutput">
              <canvas id="chart-inoutput" width="25%" height="25%"></canvas>
              <div class="chart-info">
                <h2>STATISTIC INFO</h2>
                <div class="chart-info--line">
                    <p>Status</p>
                    <p id="status"></p>
                </div>
                <div class="chart-info--line">
                    <p>Increase ratio</p>
                    <p><span id="increaseratio">0.2</span> percent</p>
                </div>
                <div class="chart-info--line">
                    <p>Next month estimate</p>
                    <p><span id="nextMonthEstimate"></span> persent</p>
                </div>
              </div>
              </div>
             
    @endif
    
    


@endsection

