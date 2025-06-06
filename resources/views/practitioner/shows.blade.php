@extends('layouts.app')

@section('content')
    <section class="practitioner-profile">
        @include('layouts.partitioner_sidebar')
        <div class="container vh-100">
            <div class="row ms-md-5">
                <div class="col-12">
                    @include('layouts.partitioner_nav')
                </div>
                <div class="col-6">
                    <h2 class="mb-4">Practitioner Shows</h2>
                </div>
                <div class="col-6">
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('practitionerAddShow') }}" class="btn btn-green">Add Show</a>
                    </div>
                </div>
                <div class="col-12">
                    <div class="table-responsive mt-3">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Duration</th>
                                <th>Price</th>
                                <th>Tax</th>
                                <th class="text-center">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($shows as $show)
                                <tr>
                                    <td>{{ $show->name}}</td>
                                    <td>{{ $show->duration }}</td>
                                    <td>{{$show->price}}</td>
                                    <td>{{ $show->tax }}</td>
                                    <td class="text-center">
                                        <span class="dropdown">
                                           <a class="align-text-top cursor" data-bs-boundary="viewport" data-bs-toggle="dropdown" aria-expanded="true">
                                               <i class="fa fa-ellipsis-v"></i>
                                            </a>
                                           <span class="dropdown-menu dropdown-menu-start">
                                                <a class="dropdown-item" href="{{ route('practitionerShowEdit', $show->id) }}">
                                                  <span class="nav-link-icon">
                                                      <i class="fa fa-edit"></i>
                                                  </span> Open
                                                </a>

                                               <form action="{{ route('practitionerShowDelete', $show->id) }}" method="POST" class="d-inline">
                                                   @csrf
                                                   @method('POST')
                                                   <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Are you sure you want to delete this show?');">
                                                       <span class="nav-link-icon">
                                                           <i class="fa fa-trash"></i>
                                                       </span> Delete
                                                   </button>
                                               </form>
                                           </span>
                                        </span>

                                        {{-- Add Delete/Details if needed --}}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No offerings found.</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
