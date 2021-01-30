@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">Dashboard</div>
        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
    
            <div class="row">
                @role('member')
                    <div class="col-6 mb-2">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Acceptance Sign</h5>
                                <p class="card-text">You accept the agreement at {{ date("d M Y, H:ia", strtotime($user->accept_at)) }}. Click here to <a href="{{ route('accept.download') }}" target="_blank">download</a>.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 mb-2">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Something here/h5>
                                <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mb-2">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Subscribe Plans</h5>
                                <p class="card-text">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Plan</th>
                                                <th scope="col">Return Investment</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                            if(count($planArr) > 0) {
                                                foreach($planArr as $key => $value) {
                                                    echo "<tr>";
                                                        echo "<th scope='row'>".($key + 1)."</th>";
                                                        echo "<td>".$value['name']."</td>";
                                                        echo "<td>".$value['price']."</td>";
                                                    echo "</tr>";
                                                }
                                            }
                                            @endphp
                                        </tbody>
                                    </table>
                                </p>
                            </div>
                        </div>
                    </div>
                @endrole
                @role('admin')
                    <div class="col-4 mb-2">
                        <div class="card">
                            <div class="card-body">
                                <p class="card-text">Participants</p>
                                <h5 class="card-title">{{ $count_member }}</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-4 mb-2">
                        <div class="card">
                            <div class="card-body">
                                <p class="card-text">With Sign</p>
                                <h5 class="card-title">{{ $count_withsign }}</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-4 mb-2">
                        <div class="card">
                            <div class="card-body">
                                <p class="card-text">Pending Sign</p>
                                <h5 class="card-title">{{ $count_withoutsign }}</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mt-3 mb-2">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse tincidunt semper fermentum. Maecenas elementum metus a imperdiet sodales. Mauris at purus quis augue posuere vulputate. Pellentesque ac quam tempor, varius libero et, dignissim felis. Donec id lorem rhoncus sapien mollis ullamcorper a nec purus. Integer vestibulum tempor leo, a cursus sem facilisis eget. Curabitur eu hendrerit dolor. Fusce massa ante, congue imperdiet semper ut, sollicitudin quis felis. Praesent finibus risus non eros mollis rutrum. Vivamus ullamcorper tortor ut enim lobortis, quis dictum arcu pharetra. In in malesuada urna, quis rhoncus ante. In posuere sem sed volutpat suscipit. Curabitur auctor consequat fringilla. Nulla gravida dictum eleifend. Pellentesque eget tellus bibendum, convallis velit sed, tempor lectus. Phasellus mollis lobortis felis at aliquet.
                        <br><br>
                        Curabitur eros erat, interdum id tellus id, porttitor pharetra purus. Nam vel condimentum enim. Mauris lectus magna, imperdiet ac nunc dignissim, dignissim iaculis neque. Curabitur id dapibus erat. Maecenas lobortis elit interdum laoreet blandit. Proin vel justo enim. Quisque sodales imperdiet leo, id posuere nulla pellentesque mattis. Nam vitae dui elit. Curabitur quis justo quis nunc rhoncus vehicula.
                        <br><br>
                        Duis dapibus nisl arcu, et facilisis justo congue nec. Phasellus eget fermentum magna. Nunc rhoncus turpis ut ex consequat, eget ultrices purus ultrices. Sed quis augue suscipit, interdum nisi at, viverra elit. Etiam non leo dapibus, maximus tortor vel, iaculis urna. Quisque vitae blandit leo, nec tempor dui. Integer convallis aliquam felis, ac pellentesque eros lacinia eget. Pellentesque lacinia, massa quis elementum sagittis, quam sapien mattis risus, quis congue nulla diam eget ipsum. Integer eget mollis sapien. Nulla purus odio, rhoncus quis velit vel, fermentum consequat augue. Maecenas bibendum semper mi, gravida accumsan odio rhoncus blandit. Phasellus venenatis sapien metus, non tempus erat mollis non. Quisque libero purus, convallis eu sollicitudin ut, hendrerit eu metus.
                    </div>
                @endrole
            </div>
        </div>
    </div>
@endsection
