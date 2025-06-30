@extends('layouts.app')

@section('content')
    <style>
        .hero { background: #eef6f2; text-align: center; padding: 3rem 1rem; }
        .card {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            /*max-width: 600px;*/
            width: 100%;
            text-align: left;
        }

        h2 {
            color: #333;
            text-align: center;
        }

        p {
            color: #555;
            line-height: 1.9;
        }

    </style>

<section class="featured-section">

    <div class="container">
        <div class="hero">
            <h1>Our Land Acknowledgement</h1>
            <p>Honoring truth, healing, and justice through Indigenous wisdom</p>
        </div>
        <div class="bg-success bg-opacity-10 border-start border-success border-5 p-3 my-4">
            <em class="fs-6">Wellness is not separate from justice. Healing is not separate from truth. Growth is not separate from accountability.</em>
        </div>

        <div class="mt-5 mb-5">
            <p>The Hira Collective acknowledges that we are created, built, and operating on lands that have long been home to Indigenous Peoples, including the Anishinaabe, Haudenosaunee, Huron-Wendat, Métis, and many others whose stories, cultures, and stewardship have shaped these lands since time immemorial.</p>

            <p>We recognize that what is now called Canada exists on stolen land, and we carry a lifelong responsibility to listen, learn, and take meaningful action toward justice, truth, and reconciliation. <strong>Wellness is not separate from justice. Healing is not separate from truth. Growth is not separate from accountability.</strong> The Hira Collective stands in solidarity with Indigenous communities, honoring the past, transforming the present, and building a future that is deeply rooted in respect, reciprocity, and the right relationship with the land and all its peoples.</p>

            <p>Honoring the roots of this land means committing to truth, reciprocity, and lifelong learning. It means showing up—imperfectly, humbly, and with a willingness to listen. <em>Colonialism thrives on the pursuit of ‘rightness’ and perfection, and we reject that.</em> We know we will not always get it right, but we believe that healing, justice, and reconciliation require action, even in the discomfort of not knowing the perfect way forward.</p>

            <p>As a collective dedicated to holistic healing, we recognize that wellness is inseparable from justice, and healing is inseparable from truth. We are committed to uplifting Indigenous voices, integrating cultural integrity into all that we do, and actively working toward a future that honors the wisdom, sovereignty, and rights of Indigenous Peoples.</p>

            <p>We invite our community to join us in this process—not just in words, but in action. We encourage continued reflection, learning, and engagement with Indigenous-led movements for land back, equity, and healing.</p>
        </div>

    </div>

    <div class="container my-5">
        <h3 class="fw-bold mb-4">Ways To Take Action</h3>

        <div class="row g-4">

            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title fw-bold">National Centre for Truth and Reconciliation (NCTR)</h5>
                        <p class="card-text">Holds the history and truths of residential school survivors and supports education and reconciliation efforts.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title fw-bold">Indigenous Climate Action</h5>
                        <p class="card-text">An Indigenous-led organization advocating for climate justice and Indigenous sovereignty.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title fw-bold">Indian Residential School Survivors Society (IRSSS)</h5>
                        <p class="card-text">Provides support to residential school survivors and their families.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title fw-bold">Native Women’s Association of Canada (NWAC)</h5>
                        <p class="card-text">Advocates for the rights and well-being of Indigenous women, girls, and gender-diverse people.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title fw-bold">Land Back Movement</h5>
                        <p class="card-text">A grassroots movement advocating for Indigenous sovereignty and the return of Indigenous lands.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title fw-bold">Local Indigenous Friendship Centre</h5>
                        <p class="card-text">Indigenous Friendship Centres provide cultural, social, and health programs.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-5">
        <div class="card bg-success bg-opacity-10 text-center">
            <div class="card-body">
                <p class="card-text text-dark fw-bolder">
                    Healing and reconciliation are ongoing. We encourage you to take the time to listen, learn, and take meaningful action in ways that honor the spirit of this land and its original caretakers.
                </p>
            </div>
        </div>
    </div>

</section>
@endsection
