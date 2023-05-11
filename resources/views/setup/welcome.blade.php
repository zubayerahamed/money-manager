<x-setup-layout pageTitle="Welcome">
    <div class="card-body">
        <h6 class="text-center">Welcome</h6>
        <ol>
            <li>Check if all requirements are met.</li>
            <li>Setup up a database and check if the connection is successful.</li>
        </ol>
    </div>

    <div class="card-footer">
        <a href="{{ route('setup.requirements') }}" class="btn btn-sm btn-success float-end">Next<i class="ph-arrow-fat-lines-right ms-2"></i></a>
    </div>
</x-setup-layout>
