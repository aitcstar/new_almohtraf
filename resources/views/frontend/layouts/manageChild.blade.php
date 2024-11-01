 <ul>
     @foreach($childs as $child)

     @if( $child->screen_id == NULL)
     <li class="drop-down"><a href="#"> {{ $child->name_ar }}</a>
     @if(count($child->childs))
                @include('frontend.layouts.manageChild',['childs' => $child->childs])
             @endif
     </li>
      
     @else
     <li><a href="{{ $child->screen->url }}"> {{ $child->name_ar }}</a></li>
     @endif


     @endforeach
 </ul>
