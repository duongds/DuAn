<html>
  <head>
    <title>test</title>
  </head>
  <body>
    <table class="table">
      <thead>
        <tr>
          <th scope="col">id</th>
          <th scope="col">job_name</th>
          <th scope="col">address</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($repo1s as $repo1)
            <tr>
                <td>{{$repo1->id}}</td>
                <td>{{$repo1->job_name}}</td>
                <td>{{$repo1->address}}</td>
                <td>
                    <a class="btn btn-warning" href="{{route('repo1.edit',$repo1->id)}}">Edit</a>
                    <button type="button" class="btn btn-danger delete-button" data-id="{{$repo1->id}}">Delete</button>
                </td>
            </tr>
        @endforeach

      </tbody>
    </table>
  </body>
</html>
