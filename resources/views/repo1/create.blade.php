<html>
    <head>
        <title>Create</title>
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    </head>
    <body>
        <div class="container">
            <div class="row">

                <div class="col-md-8 col-md-offset-2">

                    <h1>Create post</h1>

                <form action="{{route('repo1.store')}}" method="POST">
                    @csrf
                        <div class="form-group has-error">
                            <label for="name">Name <span class="require">*</span> <small>(This field use in url path.)</small></label>
                            <input type="text" class="form-control" name="name" />
                            <span class="help-block">Field not entered!</span>
                        </div>

                        <div class="form-group">
                            <label for="job_id">Job_id <span class="require">*</span></label>
                            <input type="text" class="form-control" name="job_id" />
                        </div>

                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea rows="5" class="form-control" name="address" ></textarea>
                        </div>

                        <div class="form-group">
                            <p><span class="require">*</span> - required fields</p>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                Create
                            </button>
                            <button class="btn btn-default">
                                Cancel
                            </button>
                        </div>

                    </form>
                </div>

            </div>
        </div>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
        <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    </body>
</html>
