<div>
    <label for="">Hi, this your message from John Cayde CMS Project</label>
    <label for="">Contact John Cayde immediately if you are not sending the email by you own</label>
    <table>
        <tr>
            <th>Title</th>
            <th>Content</th>
        </tr>
        @foreach ($message as $key => $value)
            <tr>
                <th>{{$key}}</th>
                <th>{{$value}}</th>
            </tr>
        @endforeach
    </table>
</div>
