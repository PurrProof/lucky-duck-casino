<div class="content mt-5">
    <h6>Comments:</h6>
    <ul class="has-text-gray is-size-7 is-disc">
        <li>Fields patterns are disabled in html, in order to make backend validation logic testable.</li>
        <li>Phone and login uniqueness is intentional.</li>
        <li>Link displayed after registration is <span class="tag">for demo</span> only. In production, SMS queues will be used for sending links.</li>
        <li>Existing login/phone returns the user's latest active link.</li>
    </ul>
    <h6>Future improvements:</h6>
    <ul class="has-text-gray is-size-7 is-disc">
        <li>Switch to MySQL or PostgreSQL and add proper indexing for performance.</li>
        <li>Send links via SMS asynchronously using queues.</li>
        <li>Add some <code>rules_id</code> field in the games table to store the rules identifier used for scoring, supporting multiple rule sets in the future.</li>
        <li>Use better phone number validation with a library like <a href="https://github.com/Propaganistas/Laravel-Phone">Laravel-Phone</a>.</li>
        <li>Improve allowed characters and patterns for login names.</li>
        <li>Implement rate limiting for login and registration to prevent spam.</li>
        <li>Write comprehensive tests for application functionality.</li>
    </ul>
</div>