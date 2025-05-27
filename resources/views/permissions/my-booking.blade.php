<tr>
    <td colspan="2">
        <h5 class="mb-0">My Booking</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="myBooking"
                   id="myBooking" @checked(in_array ('myBooking', $role -> permissions()))>
            <label class="form-check-label" for="myBooking">My Booking</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h6 class="mb-0">Book Tickets</h6>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="book-tickets"
                   id="book-tickets" @checked(in_array ('book-tickets', $role -> permissions()))>
            <label class="form-check-label" for="book-tickets">Book Tickets</label>
        </div>
    </td>
</tr>
<tr>
    <td colspan="2"></td>
    <td>
        <div class="d-flex gap-2 flex-column">
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="permission[]"
                       value="book-now-book-tickets"
                       id="book-now-book-tickets" @checked(in_array ('book-now-book-tickets', $role -> permissions()))>
                <label class="form-check-label" for="book-now-book-tickets">Book Now</label>
            </div>

        </div>
    </td>
</tr>

<tr>
    <td></td>
    <td>
        <h6 class="mb-0">Pending Booking</h6>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="pending-booking"
                   id="pending-booking" @checked(in_array ('pending-booking', $role -> permissions()))>
            <label class="form-check-label" for="pending-booking">Pending Booking</label>
        </div>
    </td>
</tr>
<tr>
    <td colspan="2"></td>
    <td>
        <div class="d-flex gap-2 flex-column">
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="permission[]"
                       value="confirm-booking-pending-booking"
                       id="confirm-booking-pending-booking" @checked(in_array ('confirm-booking-pending-booking', $role -> permissions()))>
                <label class="form-check-label" for="confirm-booking-pending-booking">Confirm Booking</label>
            </div>

            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="permission[]"
                       value="cancel-booking-pending-booking"
                       id="cancel-booking-pending-booking" @checked(in_array ('cancel-booking-pending-booking', $role -> permissions()))>
                <label class="form-check-label" for="cancel-booking-pending-booking">Cancel Booking</label>
            </div>

            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="permission[]"
                       value="edit-booking-pending-booking"
                       id="edit-booking-pending-booking" @checked(in_array ('edit-booking-pending-booking', $role -> permissions()))>
                <label class="form-check-label" for="edit-booking-pending-booking">Edit Booking</label>
            </div>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h6 class="mb-0">Cancelled Booking</h6>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="cancelled-booking"
                   id="cancelled-booking" @checked(in_array ('cancelled-booking', $role -> permissions()))>
            <label class="form-check-label" for="cancelled-booking">Cancelled Booking</label>
        </div>
    </td>
</tr>


<tr>
    <td></td>
    <td>
        <h6 class="mb-0">Confirmed Booking</h6>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="confirmed-booking"
                   id="confirmed-booking" @checked(in_array ('confirmed-booking', $role -> permissions()))>
            <label class="form-check-label" for="confirmed-booking">Confirmed Booking</label>
        </div>
    </td>
</tr>
<tr>
    <td colspan="2"></td>
    <td>
        <div class="d-flex gap-2 flex-column">
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="permission[]"
                       value="edit-confirmed-booking"
                       id="edit-confirmed-booking" @checked(in_array ('edit-confirmed-booking', $role -> permissions()))>
                <label class="form-check-label" for="edit-confirmed-booking">Edit</label>
            </div>

            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="permission[]"
                       value="cancel-booking-confirmed-booking"
                       id="cancel-booking-confirmed-booking" @checked(in_array ('cancel-booking-confirmed-booking', $role -> permissions()))>
                <label class="form-check-label" for="cancel-booking-confirmed-booking">Cancel Booking</label>
            </div>

            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="permission[]"
                       value="print-ticket-confirmed-booking"
                       id="print-ticket-confirmed-booking" @checked(in_array ('print-ticket-confirmed-booking', $role -> permissions()))>
                <label class="form-check-label" for="print-ticket-confirmed-booking">Print Ticket</label>
            </div>
        </div>
    </td>
</tr>
