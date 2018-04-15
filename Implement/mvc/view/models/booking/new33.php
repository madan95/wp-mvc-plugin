<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="main-node-form form">
        <fieldset>
          <div data-table="booking" class="input-fields">
          <div class="cover">
          <legend>Booking Form </legend>
          <label for="booking_id">Booking Id</label>
          <input type="text" name="booking_id" id="booking_id"><br>
          <label for="booking_name">Booking Name</label>
          <input type="text" name="booking_name" id="booking_name"></br>

          <div data-table="task" class="input-fields">
            <div class="cover">
            <legend>Task Form</legend>
            <label for="task_id">Task Id</label>
            <input type="text" name="task_id" id="task_id"><br>
            <label for="task_name">Task Name</label>
            <input type="text" name="task_name" id="task_name"></br>

              <div data-table="staff" class="input-fields">

                <div class="cover">
                  <legend>Staff Form</legend>
                  <label for="staff_id">Staff Id</label>
                  <input type="text" name="staff_id" id="staff_id"><br>
                  <label for="staff_name">Staff Name</label>
                  <input type="text" name="staff_name" id="staff_name"></br>
                </div> <!-- STAFF -->
                <button class="btn">Add More Staff</button>
              </div><!-- .input-fields -->

            </div> <!-- TASK -->


            <button class="btn">Add More Task</button>

          </div><!-- .input-fields -->
        </div> <!-- BOOKING -->
        </div><!-- .input-fields -->
        <button data-table_name="booking" data-action="save" class="btn testBtn">Save</button>

        </fieldset>
      </div>
    </div>
  </div>
</div>
