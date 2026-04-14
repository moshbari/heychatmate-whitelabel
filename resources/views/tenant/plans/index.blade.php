@extends('layouts/contentNavbarLayout')

@section('title', 'Manage Plans')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Subscription Plans</h5>
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
              <th>Type</th>
              <th>Credits</th>
              <th>Max Bots</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($plans as $plan)
            <tr>
              <td>
                <strong>{{ $plan->name }}</strong>
                @if ($plan->subtitle)
                  <br><small class="text-muted">{{ $plan->subtitle }}</small>
                @endif
              </td>
              <td>${{ number_format($plan->price, 2) }}</td>
              <td>{{ ucfirst($plan->type) }}</td>
              <td>{{ number_format($plan->credits) }}</td>
              <td>{{ $plan->max_bots }}</td>
              <td>{!! $plan->status ? '<span class="badge bg-label-success">Active</span>' : '<span class="badge bg-label-secondary">Inactive</span>' !!}</td>
              <td>
                <button class="btn btn-sm btn-outline-primary" onclick="editPlan({{ json_encode($plan) }})" data-bs-toggle="modal" data-bs-target="#editPlanModal">
                  <i class="bx bx-edit"></i>
                </button>
                <a href="{{ route('tenant.plans.destroy', $plan->id) }}" class="btn btn-sm btn-outline-danger" onclick="return confirm('Deactivate this plan?')">
                  <i class="bx bx-trash"></i>
                </a>
              </td>
            </tr>
            @empty
            <tr><td colspan="7" class="text-center py-4">No plans created yet. Create your first plan to offer subscriptions to your users.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Add Plan Modal -->
<div class="modal fade" id="addPlanModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('tenant.plans.store') }}" method="POST">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title">Add Plan</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-8 mb-3">
              <label class="form-label">Plan Name</label>
              <input type="text" name="name" class="form-control" required>
            </div>
            <div class="col-md-4 mb-3">
              <label class="form-label">Price ($)</label>
              <input type="number" name="price" class="form-control" step="0.01" min="0" required>
            </div>
            <div class="col-md-4 mb-3">
              <label class="form-label">Type</label>
              <select name="type" class="form-select">
                <option value="month">Monthly</option>
                <option value="year">Yearly</option>
                <option value="credit">Credit Pack</option>
              </select>
            </div>
            <div class="col-md-4 mb-3">
              <label class="form-label">Credits</label>
              <input type="number" name="credits" class="form-control" value="0" min="0" required>
            </div>
            <div class="col-md-4 mb-3">
              <label class="form-label">Max Bots</label>
              <input type="number" name="max_bots" class="form-control" value="3" min="1" required>
            </div>
            <div class="col-md-12 mb-3">
              <label class="form-label">Subtitle <small class="text-muted">(optional)</small></label>
              <input type="text" name="subtitle" class="form-control" placeholder="e.g. Best for small teams">
            </div>
            <div class="col-md-12 mb-3">
              <label class="form-label">Features <small class="text-muted">(optional, comma-separated)</small></label>
              <textarea name="features" class="form-control" rows="2" placeholder="e.g. 24/7 Support, Custom Branding"></textarea>
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
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="editPlanForm" method="POST">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title">Edit Plan</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-8 mb-3">
              <label class="form-label">Plan Name</label>
              <input type="text" name="name" id="edit_name" class="form-control" required>
            </div>
            <div class="col-md-4 mb-3">
              <label class="form-label">Price ($)</label>
              <input type="number" name="price" id="edit_price" class="form-control" step="0.01" min="0" required>
            </div>
            <div class="col-md-4 mb-3">
              <label class="form-label">Type</label>
              <select name="type" id="edit_type" class="form-select">
                <option value="month">Monthly</option>
                <option value="year">Yearly</option>
                <option value="credit">Credit Pack</option>
              </select>
            </div>
            <div class="col-md-4 mb-3">
              <label class="form-label">Credits</label>
              <input type="number" name="credits" id="edit_credits" class="form-control" min="0" required>
            </div>
            <div class="col-md-4 mb-3">
              <label class="form-label">Max Bots</label>
              <input type="number" name="max_bots" id="edit_max_bots" class="form-control" min="1" required>
            </div>
            <div class="col-md-12 mb-3">
              <label class="form-label">Subtitle</label>
              <input type="text" name="subtitle" id="edit_subtitle" class="form-control">
            </div>
            <div class="col-md-12 mb-3">
              <label class="form-label">Features</label>
              <textarea name="features" id="edit_features" class="form-control" rows="2"></textarea>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Status</label>
              <select name="status" id="edit_status" class="form-select">
                <option value="1">Active</option>
                <option value="0">Inactive</option>
              </select>
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
  document.getElementById('editPlanForm').action = '/tenant/plans/' + plan.id + '/update';
  document.getElementById('edit_name').value = plan.name;
  document.getElementById('edit_price').value = plan.price;
  document.getElementById('edit_type').value = plan.type;
  document.getElementById('edit_credits').value = plan.credits;
  document.getElementById('edit_max_bots').value = plan.max_bots;
  document.getElementById('edit_subtitle').value = plan.subtitle || '';
  document.getElementById('edit_features').value = plan.features || '';
  document.getElementById('edit_status').value = plan.status;
}
</script>
@endsection
@endsection
