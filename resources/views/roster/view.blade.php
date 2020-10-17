<table class="table align-items-center table-flush">

<thead class="thead-light">
  <tr>
    <th rowspan="2" scope="col">Employees</th>
    @foreach($data[0]['dates'] as $row)
    <th scope="col">{{ $row['day'] }}</th>
    @endforeach
  </tr>
  <tr>
    @foreach($data[0]['dates'] as $row)
    <th scope="col">{{ $row['date'] }}</th>
    @endforeach
  </tr>

</thead>



<tbody>

  @foreach($data as $row)
    <tr>
      <td>{{ $row['employee']->full_name.' - '.\App\Http\Controllers\HelperController::employeeCode($row['employee']->id) }}</td>
      @foreach($row['dates'] as $dates)
      <td>{{ $dates['shift'] }}</td>
      @endforeach
    </tr>
  @endforeach

</tbody>

<tfoot class="thead-light">
  <tr>
    <th rowspan="2" scope="col">Employees</th>
    @foreach($data[0]['dates'] as $row)
    <th scope="col">{{ $row['day'] }}</th>
    @endforeach
  </tr>
  <tr>
    @foreach($data[0]['dates'] as $row)
    <th scope="col">{{ $row['date'] }}</th>
    @endforeach
  </tr>
</tfoot>

</table>
