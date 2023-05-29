@extends('layouts.app')

@section('title', 'Frequently Asked Questions')

@section('active')

@section('content')

@include('parts.small_header_extend')

<div class="container">
    <div class="row">

      <div class="row">
        <div class="col-md-8 auto">
          <h1>@lang('page.about.title')</h1>
          <p class="lead">@lang('page.about.description')</p>
          <h2>@lang('page.about.vision')</h2>
          <p>@lang('page.about.vision_cont')</p>
          <h2>@lang('mission')</h2>
          <p>@lang('page.about.mission_content')</p>



          <hr class="hidden-xs hidden-sm">
      </div>
  </div>
  
  <div class="row">
    <div class="col-md-4">
      <!-- <p>Matias Møl Dalsgaard and Søren Riis founded GoMore in 2005, while they were studying 
      philosophy in Germany. The site quickly became 
      the leading ridesharing portal in Denmark, and existed for many years as a spare-time project.
  </p> -->
</div>
<div class="col-md-4">
  <!-- <p>In 2011 partners Lasse Gejl and Jacob Tjørnholm joined the team, and GoMore was relaunched on new technology. 
      In 2013 GoMore received angel investment from Jesper Buch, and the team went full time.
  </p> -->
</div>

<div class="col-md-4">
  <p class="small"> @lang('page.about.find-us')</p>
</div>
</div>

<!-- <h2 class="c-heading-section">Customer Experience</h2>
<div class="row flex flex-same-col-height">
    <div class="col-xs-12 col-sm-4 col-md-3 mv3 tcenter minh-200">
        <img alt="Image" class="img-circle w-120 h-120" src=" ">
        <span class="mt3 block">
            Name Here
        </span>
        <span class="block small">Customer Experience Manager</span>
        <a href="mailto:josephine@gomore.com" class="important">namehere@gokamz.com</a>
    </div>

    <div class="col-xs-12 col-sm-4 col-md-3 mv3 tcenter minh-200">
        <img alt="Image" class="img-circle w-120 h-120" src=" ">
        <span class="mt3 block">
           Name Here
        </span>
        <span class="block small">Customer Care Team Leader</span>
        <a href="mailto:kibsgaard@gomore.com" class="important">namehere@gokamz.com</a>
    </div>

    <div class="col-xs-12 col-sm-4 col-md-3 mv3 tcenter minh-200">
        <img alt="Image" class="img-circle w-120 h-120" src=" ">
        <span class="mt3 block">
            Name Here
        </span>
        <span class="block small">Customer Care</span>
        <a href="mailto:support@gomore.dk" class="important">namehere@gokamz.com</a>
    </div>

    <div class="col-xs-12 col-sm-4 col-md-3 mv3 tcenter minh-200">
        <img alt="Image" class="img-circle w-120 h-120" src=" ">
        <span class="mt3 block">
            Name Here
        </span>
        <span class="block small">Customer Care</span>
        <a href="mailto:support@gomore.dk" class="important">namehere@gokamz.com</a>
    </div>

    <div class="col-xs-12 col-sm-4 col-md-3 mv3 tcenter minh-200">
        <img alt="Image" class="img-circle w-120 h-120" src=" ">
        <span class="mt3 block">
            Name Here
        </span>
        <span class="block small">Customer Care</span>
        <a href="mailto:support@gomore.dk" class="important">namehere@gokamz.com</a>
    </div>

    <div class="col-xs-12 col-sm-4 col-md-3 mv3 tcenter minh-200">
        <img alt="Image" class="img-circle w-120 h-120" src=" ">
        <span class="mt3 block">
            Name Here
        </span>
        <span class="block small">Customer Care</span>
        <a href="mailto:support@gomore.dk" class="important">namehere@gokamz.com</a>
    </div>

    <div class="col-xs-12 col-sm-4 col-md-3 mv3 tcenter minh-200">
        <img alt="Image" class="img-circle w-120 h-120" src=" ">
        <span class="mt3 block">
            Name Here
        </span>
        <span class="block small">Customer Care</span>
        <a href="mailto:support@gomore.dk" class="important">namehere@gokamz.com</a>
    </div>

    <div class="col-xs-12 col-sm-4 col-md-3 mv3 tcenter minh-200">
        <img alt="Image" class="img-circle w-120 h-120" src=" ">
        <span class="mt3 block">
           Name Here
        </span>
        <span class="block small">Customer Care</span>
        <a href="mailto:support@gomore.dk" class="important">namehere@gokamz.com</a>
    </div>

    <div class="col-xs-12 col-sm-4 col-md-3 mv3 tcenter minh-200">
        <img alt="Image" class="img-circle w-120 h-120" src=" ">
        <span class="mt3 block">
            FName Here
        </span>
        <span class="block small">Customer Care</span>
        <a href="mailto:support@gomore.dk" class="important">namehere@gokamz.com</a>
    </div>

    <div class="col-xs-12 col-sm-4 col-md-3 mv3 tcenter minh-200">
        <img alt="Image" class="img-circle w-120 h-120" src=" ">
        <span class="mt3 block">
            Name Here
        </span>
        <span class="block small">Customer Experience Team Leader</span>
        <a href="mailto:norgaard@gomore.com" class="important">namehere@gokamz.com</a>
    </div>

    <div class="col-xs-12 col-sm-4 col-md-3 mv3 tcenter minh-200">
        <img alt="Image" class="img-circle w-120 h-120" src=" ">
        <span class="mt3 block">
           Name Here
        </span>
        <span class="block small">Customer Experience</span>
        <a href="mailto:experience@gomore.dk" class="important">namehere@gokamz.com</a>
    </div>

    <div class="col-xs-12 col-sm-4 col-md-3 mv3 tcenter minh-200">
        <img alt="Image" class="img-circle w-120 h-120" src=" ">
        <span class="mt3 block">
            Name Here
        </span>
        <span class="block small">Customer Experience</span>
        <a href="mailto:experience@gomore.dk" class="important">namehere@gokamz.com</a>
    </div>

    <div class="col-xs-12 col-sm-4 col-md-3 mv3 tcenter minh-200">
        <img alt="Image" class="img-circle w-120 h-120" src=" ">
        <span class="mt3 block">
            Name Here
        </span>
        <span class="block small">Customer Experience</span>
        <a href="mailto:experience@gomore.dk" class="important">namehere@gokamz.com</a>
    </div>

    <div class="col-xs-12 col-sm-4 col-md-3 mv3 tcenter minh-200">
        <img alt="Image" class="img-circle w-120 h-120" src=" ">
        <span class="mt3 block">
            Name Here
        </span>
        <span class="block small">Customer Experience</span>
        <a href="mailto:experience@gomore.dk" class="important">namehere@gokamz.com</a>
    </div>

    <div class="col-xs-12 col-sm-4 col-md-3 mv3 tcenter minh-200">
        <img alt="Image" class="img-circle w-120 h-120" src=" ">
        <span class="mt3 block">
            Name Here
        </span>
    </div>

</div>

<h2 class="c-heading-section">Marketing</h2>
<div class="row flex flex-same-col-height">
    <div class="col-xs-12 col-sm-4 col-md-3 mv3 tcenter minh-200">
        <img alt="Image" class="img-circle w-120 h-120" src=" ">
        <span class="mt3 block">
            Name Here
        </span>
        <span class="block small">Online Marketing Manager</span>
        <a href="mailto:anna@gomore.com" class="important">namehere@gokamz.com</a>
    </div>

    <div class="col-xs-12 col-sm-4 col-md-3 mv3 tcenter minh-200">
        <img alt="Image" class="img-circle w-120 h-120" src=" ">
        <span class="mt3 block">
            Name Here
        </span>
        <span class="block small">Online Marketing Specialist</span>
        <a href="mailto:tobias@gomore.com" class="important">namehere@gokamz.com</a>
    </div>

    <div class="col-xs-12 col-sm-4 col-md-3 mv3 tcenter minh-200">
        <img alt="Image" class="img-circle w-120 h-120" src=" ">
        <span class="mt3 block">
           Name Here
        </span>
        <span class="block small">PR &amp; Communications</span>
        <a href="mailto:sonja@gomore.com" class="important">namehere@gokamz.com</a>
    </div>

    <div class="col-xs-12 col-sm-4 col-md-3 mv3 tcenter minh-200">
        <img alt="Image" class="img-circle w-120 h-120" src=" ">
        <span class="mt3 block">
            Name Here
        </span>
        <span class="block small">Copywriter</span>
        <a href="mailto:joachim@gomore.com" class="important">namehere@gokamz.com</a>
    </div>

</div>

<h2 class="c-heading-section">Product Development</h2>
<div class="row flex flex-same-col-height">
    <div class="col-xs-12 col-sm-4 col-md-3 mv3 tcenter minh-200">
        <img alt="Image" class="img-circle w-120 h-120" src=" ">
        <span class="mt3 block">
            Name Here
        </span>
        <span class="block small">Chief Product Officer (CPO)</span>
        <a href="mailto:frederik@gomore.com" class="important">namehere@gokamz.com</a>
    </div>

    <div class="col-xs-12 col-sm-4 col-md-3 mv3 tcenter minh-200">
        <img alt="Image" class="img-circle w-120 h-120" src=" ">
        <span class="mt3 block">
            Name Here
        </span>
        <span class="block small">Product Designer</span>
    </div>

    <div class="col-xs-12 col-sm-4 col-md-3 mv3 tcenter minh-200">
        <img alt="Image" class="img-circle w-120 h-120" src=" ">
        <span class="mt3 block">
            Name Here
        </span>
        <span class="block small">Clojure Developer</span>
    </div>

    <div class="col-xs-12 col-sm-4 col-md-3 mv3 tcenter minh-200">
        <img alt="Image" class="img-circle w-120 h-120" src=" ">
        <span class="mt3 block">
            Name Here
        </span>
        <span class="block small">Product Designer</span>
    </div>

    <div class="col-xs-12 col-sm-4 col-md-3 mv3 tcenter minh-200">
        <img alt="Image" class="img-circle w-120 h-120" src=" ">
        <span class="mt3 block">
            Name Here
        </span>
        <span class="block small">iOS Developer</span>
    </div>

    <div class="col-xs-12 col-sm-4 col-md-3 mv3 tcenter minh-200">
        <img alt="ImageImage" class="img-circle w-120 h-120" src=" ">
        <span class="mt3 block">
            Name Here
        </span>
        <span class="block small">Rails/Clojure Developer</span>
        <a href="mailto:jacob@gomore.com" class="important">namehere@gokamz.com</a>
    </div>

    <div class="col-xs-12 col-sm-4 col-md-3 mv3 tcenter minh-200">
        <img alt="Image" class="img-circle w-120 h-120" src=" ">
        <span class="mt3 block">
            Name Here
        </span>
        <span class="block small">Android Developer</span>
    </div>

    <div class="col-xs-12 col-sm-4 col-md-3 mv3 tcenter minh-200">
        <img alt="Image" class="img-circle w-120 h-120" src=" ">
        <span class="mt3 block">
            Name Here
        </span>
        <span class="block small">Android Developer</span>
    </div>

    <div class="col-xs-12 col-sm-4 col-md-3 mv3 tcenter minh-200">
        <img alt="Image" class="img-circle w-120 h-120" src=" ">
        <span class="mt3 block">
            Name Here
        </span>
        <span class="block small">DevOps</span>
    </div>

    <div class="col-xs-12 col-sm-4 col-md-3 mv3 tcenter minh-200">
        <img alt="Image" class="img-circle w-120 h-120" src=" ">
        <span class="mt3 block">
            Name Here
        </span>
        <span class="block small">Frontend Developer</span>
    </div>

    <div class="col-xs-12 col-sm-4 col-md-3 mv3 tcenter minh-200">
        <img alt="Image" class="img-circle w-120 h-120" src=" ">
        <span class="mt3 block">
            Name Here
        </span>
        <span class="block small">iOS Developer</span>
    </div>

    <div class="col-xs-12 col-sm-4 col-md-3 mv3 tcenter minh-200">
        <img alt="Image" class="img-circle w-120 h-120" src=" ">
        <span class="mt3 block">
            Name Here
        </span>
        <span class="block small">Rails/Clojure Developer</span>
    </div>

    <div class="col-xs-12 col-sm-4 col-md-3 mv3 tcenter minh-200">
        <img alt="Image" class="img-circle w-120 h-120" src=" ">
        <span class="mt3 block">
            Name Here
        </span>
        <span class="block small">iOS Developer</span>
    </div>

</div>

<h2 class="c-heading-section">Administration</h2>
<div class="row flex flex-same-col-height">
    <div class="col-xs-12 col-sm-4 col-md-3 mv3 tcenter minh-200">
        <a href="http://www.linkedin.com/pub/matias-m%C3%B8l-dalsgaard/1/518/803">
          <img alt="Image" class="img-circle w-120 h-120" src=" ">
      </a>
      <span class="mt3 block">
        Name Here
    </span>
    <span class="block small">CEO / Co-Founder</span>
</div>

<div class="col-xs-12 col-sm-4 col-md-3 mv3 tcenter minh-200">
    <a href="http://www.linkedin.com/pub/s%C3%B8ren-riis/2/b11/3ba">
      <img alt="Image" class="img-circle w-120 h-120" src=" ">
  </a>
  <span class="mt3 block">
    Name Here
</span>
<span class="block small">Co-Founder</span>
</div>

<div class="col-xs-12 col-sm-4 col-md-3 mv3 tcenter minh-200">
    <img alt="Image" class="img-circle w-120 h-120" src=" ">
    <span class="mt3 block">
        Name Here
    </span>
    <span class="block small">Market Manager SE</span>
</div>

<div class="col-xs-12 col-sm-4 col-md-3 mv3 tcenter minh-200">
    <img alt="Image" class="img-circle w-120 h-120" src=" ">
    <span class="mt3 block">
        Name Here
    </span>
    <span class="block small">Market Manager NO</span>
    <a href="mailto:aasmund@gomore.com" class="important">aasmund@gomore.com</a>
</div>

<div class="col-xs-12 col-sm-4 col-md-3 mv3 tcenter minh-200">
    <img alt="Image" class="img-circle w-120 h-120" src=" ">
    <span class="mt3 block">
        Name Here
    </span>
    <span class="block small">Growth &amp; Customer Experience <br>Manager NO/SE</span>
    <a href="mailto:klara@gomore.com" class="important">klara@gomore.com</a>
</div>

<div class="col-xs-12 col-sm-4 col-md-3 mv3 tcenter minh-200">
    <img alt="Image" class="img-circle w-120 h-120" src=" ">
    <span class="mt3 block">
        Name Here
    </span>
    <span class="block small">Executive Assistant <br>People &amp; Culture Manager</span>
    <a href="mailto:gunhild@gomore.com" class="important">gunhild@gomore.com</a>
</div>

<div class="col-xs-12 col-sm-4 col-md-3 mv3 tcenter minh-200">
    <img alt="Image" class="img-circle w-120 h-120" src=" ">
    <span class="mt3 block">
        Name Here
    </span>
    <span class="block small">Financial Controller</span>
</div>

<div class="col-xs-12 col-sm-4 col-md-3 mv3 tcenter minh-200">
    <img alt="Image" class="img-circle w-120 h-120" src=" ">
    <span class="mt3 block">
        Name Here
    </span>
    <span class="block small">Office Assistant</span>
</div>

<div class="col-xs-12 col-sm-4 col-md-3 mv3 tcenter minh-200">
    <img alt="Image" class="img-circle w-120 h-120" src=" ">
    <span class="mt3 block">
        Name Here
    </span>
    <span class="block small">Market Assistant</span>
</div>

<div class="col-xs-12 col-sm-4 col-md-3 mv3 tcenter minh-200">
    <img alt="Image" class="img-circle w-120 h-120" src=" ">
    <span class="mt3 block">
        Name Here
    </span>
    <span class="block small">Business Analyst</span>
</div>

</div>

</div> -->

<div class="col-md-8 col-md-offset-2">
    <div class="panel panel-default">
        <!-- <h1>About Gokamz</h1> -->
        <div class="panel-body">

            @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
            @endif

        </div>
    </div>
</div>
</div>
</div>
@endsection
