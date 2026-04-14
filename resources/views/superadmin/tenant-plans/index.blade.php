@extends('layouts/contentNavbarLayout')

@section('title', 'Tenant Plans')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Tenant Plans</h5>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPlanModal">
          <i class="bx bx-plus me-1"></i> Add Plan
        </button>
      </div>
      <div class="table-responsive text-nowrap">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>Name</th>
              <th>Price</th>
              <th>Cycle</th>
              <th>Max Users</th>
              <th>Max Bots</th>
              <th>Credits</th>
              <th>Custom Domain</th>
              <th>Own API Key</th>
              <th>Tenants</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($plans as $plan)
            <tr>
              <td><strong>{{ $plan->name }}</strong></td>
              <td>${{ number_format($plan->price, 2) }}</td>
              <td>{{ ucfirst($plan->billing_cycle) }}</td>
              <td>{{ $plan->max_users }}</td>
              <td>{{ $plan->max_bots_per_user }}</td>
              <td>{{ number_format($plan->credits_included) }}</td>
              <td>{!! $plan->custom_domain_allowed ? '<i class="bx bx-check text-success"></i>' : '<i class="bx bx-x text-danger"></i>' !!}</td>
              <td>{!! $plan->own_api_key_allowed ? '<i class="bx bx-check text-success"></i>' : '<i class="bx bx-x text-danger"></i>' !!}</td>
              <td>{{ $plan->tenants_count }}</td>
              <td>{!! $plan->status ? '<span class="badge bg-label-success">Active</span>' : '<span class="badge bg-label-secondary">Inactive</span>' !!}</td>
              <td>
                <button class="btn btn-sm btn-outline-primary" onclick="editPlan({{ json_encode($plan) }})" data-bs-toggle="modal" data-bs-target="#editPlanModal">
                  <i class="bx bx-edit"></i>
                </button>
              </td>
            </tr>
            @empty
            <tr><td colspan="11" class="text-center py-4">No plans created yet.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Add Plan Modal -->
<div class="modal fade" id="addPlanModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form action="{{ route('superadmin.tenant-plans.store') }}" method="POST">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title">Add Tenant Plan</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Plan Name</label>
              <input type="text" name="name" class="form-control" required>
            </div>
            <div class="col-md-3 mb-3">
              <label class="form-label">Price ($)</label>
              <input type="number" name="price" class="form-control" step="0.01" min="0" required>
            </div>
            <div class="col-md-3 mb-3">
              <label class="form-label">Billing Cycle</label>
              <select name="billing_cycle" class="form-select">
                <option value="monthly">Monthly</option>
                <option value="yearly">Yearly</option>
                <option value="one-time">One-Time</option>
              </select>
            </div>
            <div class="col-md-4 mb-3">
              <label class="form-label">Max Users</label>
              <input type="number" name="max_users" class="form-control" value="5" min="1" required>
            </div>
            <div class="col-md-4 mb-3">
              <label class="form-label">Max Bots per User</label>
              <input type="number" name="max_bots_per_user" class="form-control" value="3" min="1" required>
            </div>
            <div class="col-md-4 mb-3">
              <label class="form-label">Credits Included</label>
              <input type="number" name="credits_included" class="form-control" value="0" min="0" required>
            </div>
            <div class="col-md-4 mb-3">
              <div class="form-check mt-4">
                <input class="form-check-input" type="checkbox" name="custom_domain_allowed" value="1" id="addCustomDomain">
                <label class="form-check-label" for="addCustomDomain">Custom Domain</label>
              </div>
            </div>
            <div class="col-md-4 mb-3">
              <div class="form-check mt-4">
                <input class="form-check-input" type="checkbox" name="own_api_key_allowed" value="1" id="addOwnApiKey">
                <label class="form-check-label" for="addOwnApiKey">Own API Key</label>
              </div>
            </div>
            <div class="col-md-4 mb-3">
              <div class="form-check mt-4">
                <input class="form-check-input" type="checkbox" name="white_label_full" value="1" id="addWhiteLabel">
                <label class="form-check-label" for="addWhiteLabel">Full White Label</label>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Create Plan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Edit Plan Modal -->
<div class="modal fade" id="editPlanModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form id="editPlanForm" method="POST">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title">Edit Tenant Plan</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Plan Name</label>
              <input type="text" name="name" id="edit_name" class="form-control" required>
            </div>
            <div class="col-md-3 mb-3">
              <label class="form-label">Price ($)</label>
              <input type="number" name="price" id="edit_price" class="form-control" step="0.01" min="0" required>
            </div>
            <div class="col-md-3 mb-3">
              <label class="form-label">Billing Cycle</label>
              <select name="billing_cycle" id="edit_billing_cycle" class="form-select">
                <option value="monthly">Monthly</option>
                <option value="yearly">Yearly</option>
                <option value="one-time">One-Time</option>
              </select>
            </div>
            <div class="col-md-4 mb-3">
              <label class="form-label">Max Users</label>
              <input type="number" name="max_users" id="edit_max_users" class="form-control" min="1" required>
            </div>
            <div class="col-md-4 mb-3">
              <label class="form-label">Max Bots per User</label>
              <input type="number" name="max_bots_per_user" id="edit_max_bots" class="form-control" min="1" required>
            </div>
            <div class="col-md-4 mb-3">
              <label class="form-label">Credits Included</label>
              <input type="number" name="credits_included" id="edit_credits" class="form-control" min="0" required>
            </div>
            <div class="col-md-4 mb-3">
              <div class="form-check mt-4">
                <input class="form-check-input" type="checkbox" name="custom_domain_allowed" value="1" id="edit_custom_domain">
                <label class="form-check-label" for="edit_custom_domain">Custom Domain</label>
              </div>
            </div>
            <div class="col-md-4 mb-3">
              <div class="form-check mt-4">
                <input class="form-check-input" type="checkbox" name="own_api_key_allowed" value="1" id="edit_own_api">
                <label class="form-check-label" for="edit_own_api">Own API Key</label>
              </div>
            </div>
            <div class="col-md-4 mb-3">
              <div class="form-check mt-4">
                <input class="form-check-input" type="checkbox" name="white_label_full" value="1" id="edit_white_label">
                <label class="form-check-label" for="edit_white_label">Full White Label</label>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Update Plan</button>
        </div>
      </form>
    </div>
  </div>
</div>

@if (session('success'))
<script>
  document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({ icon: 'success', title: 'Success', text: '{{ session("success") }}', timer: 3000, showConfirmButton: false });
  });
</script>
@endif

@section('page-script')
<script>
function editPlan(plan) {
  document.getElementById('editPlanForm').action = '/superadmin/tenant-plans/' + plan.id + '/update';
  document.getElementById('edit_name').value = plan.name;
  document.getElementById('edit_price').value = plan.price;
  document.getElementById('edit_billing_cycle').value = plan.billing_cycle;
  document.getElementById('edit_max_users').value = plan.max_users;
  document.getElementById('edit_max_bots').value = plan.max_bots_per_user;
  document.getElementById('edit_credits').value = plan.credits_included;
  document.getElementById('edit_custom_domain').checked = plan.custom_domain_allowed;
  document.getElementById('edit_own_api').checked = plan.own_api_key_allowed;
  document.getElementById('edit_white_label').checked = plan.white_label_full;
}
</script>
@endsection
@endsection
