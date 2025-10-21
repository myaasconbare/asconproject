<div class="main-content" data-simplebar="">
    <div class="row">
        <div class="col-lg-12">
            <div class="row g-4">
                <div class="col-lg-5">
                    <div class="i-card-sm mb-4">
                        <h5 class="title">Trade logs</h5>
                        <div class="d-flex align-items-center gap-3 mb-4">
                            <div class="i-card-sm bg--dark shadow-none flex-grow-1 py-3 px-4 rounded-3">
                                <span class="inline-block lh-1 text--light">Trade Balance</span>
                                <h5 class="mt-2">$0.08</h5>
                            </div>
                            <div class="i-card-sm bg--dark shadow-none flex-grow-1 py-3 px-4 rounded-3">
                                <span class="inline-block lh-1 text--light">Practice Balance</span>
                                <h5 class="mt-2">$0</h5>
                            </div>
                        </div>

                        <ul class="d-flex flex-column gap-2">
                            <li class="p-3 d-flex bg--dark">
                                <div class="flex-grow-1 d-flex align-items-center gap-3">
                                    <h5 class="text--light fs-14">Total Trade Amount</h5>
                                </div>
                                <div class="flex-shrink-0 text-end">
                                    <h5 class="text-white fw-bold fs-14">$1677.87</h5>
                                </div>
                            </li>
                            <li class="p-3 d-flex bg--dark">
                                <div class="flex-grow-1 d-flex align-items-center gap-3">
                                    <h5 class="text--light fs-14">Today Trading</h5>
                                </div>
                                <div class="flex-shrink-0 text-end">
                                    <h5 class="text-white fw-bold fs-14">$0</h5>
                                </div>
                            </li>
                            <li class="p-3 d-flex bg--dark">
                                <div class="flex-grow-1 d-flex align-items-center gap-3">
                                    <h5 class="text--light fs-14">Wining Amount</h5>
                                </div>
                                <div class="flex-shrink-0 text-end">
                                    <h5 class="text-white fw-bold fs-14">$263.93</h5>
                                </div>
                            </li>
                            <li class="p-3 d-flex bg--dark">
                                <div class="flex-grow-1 d-flex align-items-center gap-3">
                                    <h5 class="text--light fs-14">Loss Amount</h5>
                                </div>
                                <div class="flex-shrink-0 text-end">
                                    <h5 class="text-white fw-bold fs-14">$660.48</h5>
                                </div>
                            </li>
                            <li class="p-3 d-flex bg--dark">
                                <div class="flex-grow-1 d-flex align-items-center gap-3">
                                    <h5 class="text--light fs-14">Draw Amount</h5>
                                </div>
                                <div class="flex-shrink-0 text-end">
                                    <h5 class="text-white fw-bold fs-14">$753.46</h5>
                                </div>
                            </li>
                            <li class="p-3 d-flex bg--dark">
                                <div class="flex-grow-1 d-flex align-items-center gap-3">
                                    <h5 class="text--light fs-14">High Amount</h5>
                                </div>
                                <div class="flex-shrink-0 text-end">
                                    <h5 class="text-white fw-bold fs-14">$1426.82</h5>
                                </div>
                            </li>
                            <li class="p-3 d-flex bg--dark">
                                <div class="flex-grow-1 d-flex align-items-center gap-3">
                                    <h5 class="text--light fs-14">Low Amount</h5>
                                </div>
                                <div class="flex-shrink-0 text-end">
                                    <h5 class="text-white fw-bold fs-14">$251.05</h5>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="i-card-sm">
                        <div id="totalTrade"></div>
                    </div>
                </div>
            </div>

            <div class="i-card-sm mb-4">
                <div class="card-header">
                    <h4 class="title">Trade logs</h4>
                </div>
                <div class="filter-area">
                    <form>
                        <div class="row row-cols-lg-4 row-cols-md-4 row-cols-sm-2 row-cols-1 g-3">
                            <div class="col">
                                <select class="select2-js" name="outcome">
                                    <option value="1">INITIATED</option>
                                    <option value="2">WIN</option>
                                    <option value="3">LOSE</option>
                                    <option value="4">DRAW</option>
                                </select>
                            </div>
                            <div class="col">
                                <select class="select2-js" name="volume">
                                    <option value="1">HIGH</option>
                                    <option value="2">LOW</option>
                                </select>
                            </div>
                            <div class="col">
                                <input type="text" id="date" class="form-control datepicker-here" name="date"
                                    value="" data-range="true" data-multiple-dates-separator=" - "
                                    data-language="en" data-position="bottom right" autocomplete="off"
                                    placeholder="Date">
                            </div>
                            <div class="col">
                                <button type="submit" class="i-btn btn--lg btn--primary w-100"><i
                                        class="bi bi-search me-3"></i>Search</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="table-container">
                    <table id="myTable" class="table">
                        <thead>
                            <tr>
                                <th scope="col">Initiated At</th>
                                <th scope="col">Crypto</th>
                                <th scope="col">Price</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Arrival Time</th>
                                <th scope="col">Volume</th>
                                <th scope="col">Outcome</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td data-label="Initiated At">
                                    2024-09-28 02:05 AM
                                </td>
                                <td data-label="Crypto">
                                    Bitcoin
                                </td>
                                <td data-label="Price">
                                    $65708
                                </td>
                                <td data-label="Amount">
                                    <span class="text--primary">$0.1</span>
                                </td>
                                <td data-label="Arrival Time">
                                    2024-09-28 02:06 AM
                                </td>
                                <td data-label="Volume">
                                    <span class="i-badge badge--danger">
                                        Low
                                    </span>
                                </td>
                                <td data-label="Outcome">
                                    <span class="i-badge badge--info">
                                        Draw
                                    </span>
                                </td>
                                <td data-label="Status">
                                    <span class="i-badge badge--success">
                                        Complete
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td data-label="Initiated At">
                                    2024-09-28 02:04 AM
                                </td>
                                <td data-label="Crypto">
                                    Bitcoin
                                </td>
                                <td data-label="Price">
                                    $65708
                                </td>
                                <td data-label="Amount">
                                    <span class="text--primary">$0.1</span>
                                </td>
                                <td data-label="Arrival Time">
                                    2024-09-28 02:05 AM
                                </td>
                                <td data-label="Volume">
                                    <span class="i-badge badge--success">
                                        High
                                    </span>
                                </td>
                                <td data-label="Outcome">
                                    <span class="i-badge badge--info">
                                        Draw
                                    </span>
                                </td>
                                <td data-label="Status">
                                    <span class="i-badge badge--success">
                                        Complete
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td data-label="Initiated At">
                                    2024-09-28 12:44 AM
                                </td>
                                <td data-label="Crypto">
                                    Bitcoin
                                </td>
                                <td data-label="Price">
                                    $65594
                                </td>
                                <td data-label="Amount">
                                    <span class="text--primary">$0.1</span>
                                </td>
                                <td data-label="Arrival Time">
                                    2024-09-28 12:45 AM
                                </td>
                                <td data-label="Volume">
                                    <span class="i-badge badge--danger">
                                        Low
                                    </span>
                                </td>
                                <td data-label="Outcome">
                                    <span class="i-badge badge--info">
                                        Draw
                                    </span>
                                </td>
                                <td data-label="Status">
                                    <span class="i-badge badge--success">
                                        Complete
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td data-label="Initiated At">
                                    2024-09-25 03:24 AM
                                </td>
                                <td data-label="Crypto">
                                    Bitcoin
                                </td>
                                <td data-label="Price">
                                    $64267
                                </td>
                                <td data-label="Amount">
                                    <span class="text--danger">$0.1</span>
                                </td>
                                <td data-label="Arrival Time">
                                    2024-09-25 03:25 AM
                                </td>
                                <td data-label="Volume">
                                    <span class="i-badge badge--success">
                                        High
                                    </span>
                                </td>
                                <td data-label="Outcome">
                                    <span class="i-badge badge--danger">
                                        Lose
                                    </span>
                                </td>
                                <td data-label="Status">
                                    <span class="i-badge badge--success">
                                        Complete
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td data-label="Initiated At">
                                    2024-09-24 05:42 PM
                                </td>
                                <td data-label="Crypto">
                                    Bitcoin
                                </td>
                                <td data-label="Price">
                                    $63593
                                </td>
                                <td data-label="Amount">
                                    <span class="text--primary">$0.1</span>
                                </td>
                                <td data-label="Arrival Time">
                                    2024-09-24 05:43 PM
                                </td>
                                <td data-label="Volume">
                                    <span class="i-badge badge--success">
                                        High
                                    </span>
                                </td>
                                <td data-label="Outcome">
                                    <span class="i-badge badge--info">
                                        Draw
                                    </span>
                                </td>
                                <td data-label="Status">
                                    <span class="i-badge badge--success">
                                        Complete
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td data-label="Initiated At">
                                    2024-09-24 04:06 PM
                                </td>
                                <td data-label="Crypto">
                                    Bitcoin
                                </td>
                                <td data-label="Price">
                                    $63586
                                </td>
                                <td data-label="Amount">
                                    <span class="text--primary">$0.6</span>
                                </td>
                                <td data-label="Arrival Time">
                                    2024-09-24 04:07 PM
                                </td>
                                <td data-label="Volume">
                                    <span class="i-badge badge--success">
                                        High
                                    </span>
                                </td>
                                <td data-label="Outcome">
                                    <span class="i-badge badge--info">
                                        Draw
                                    </span>
                                </td>
                                <td data-label="Status">
                                    <span class="i-badge badge--success">
                                        Complete
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td data-label="Initiated At">
                                    2024-09-24 02:33 PM
                                </td>
                                <td data-label="Crypto">
                                    Bitcoin
                                </td>
                                <td data-label="Price">
                                    $63716
                                </td>
                                <td data-label="Amount">
                                    <span class="text--primary">$0.5</span>
                                </td>
                                <td data-label="Arrival Time">
                                    2024-09-24 02:34 PM
                                </td>
                                <td data-label="Volume">
                                    <span class="i-badge badge--success">
                                        High
                                    </span>
                                </td>
                                <td data-label="Outcome">
                                    <span class="i-badge badge--info">
                                        Draw
                                    </span>
                                </td>
                                <td data-label="Status">
                                    <span class="i-badge badge--success">
                                        Complete
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td data-label="Initiated At">
                                    2024-09-24 01:12 PM
                                </td>
                                <td data-label="Crypto">
                                    Bitcoin
                                </td>
                                <td data-label="Price">
                                    $63404
                                </td>
                                <td data-label="Amount">
                                    <span class="text--primary">$0.04</span>
                                </td>
                                <td data-label="Arrival Time">
                                    2024-09-24 01:13 PM
                                </td>
                                <td data-label="Volume">
                                    <span class="i-badge badge--danger">
                                        Low
                                    </span>
                                </td>
                                <td data-label="Outcome">
                                    <span class="i-badge badge--info">
                                        Draw
                                    </span>
                                </td>
                                <td data-label="Status">
                                    <span class="i-badge badge--success">
                                        Complete
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td data-label="Initiated At">
                                    2024-09-24 04:29 AM
                                </td>
                                <td data-label="Crypto">
                                    Bitcoin
                                </td>
                                <td data-label="Price">
                                    $63284
                                </td>
                                <td data-label="Amount">
                                    <span class="text--primary">$0.8</span>
                                </td>
                                <td data-label="Arrival Time">
                                    2024-09-24 04:30 AM
                                </td>
                                <td data-label="Volume">
                                    <span class="i-badge badge--danger">
                                        Low
                                    </span>
                                </td>
                                <td data-label="Outcome">
                                    <span class="i-badge badge--info">
                                        Draw
                                    </span>
                                </td>
                                <td data-label="Status">
                                    <span class="i-badge badge--success">
                                        Complete
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td data-label="Initiated At">
                                    2024-09-23 11:50 PM
                                </td>
                                <td data-label="Crypto">
                                    Bitcoin
                                </td>
                                <td data-label="Price">
                                    $63229
                                </td>
                                <td data-label="Amount">
                                    $0.1
                                    +
                                    $0
                                    =
                                    <span class="text--success">
                                        $0.1
                                    </span>
                                </td>
                                <td data-label="Arrival Time">
                                    2024-09-23 11:51 PM
                                </td>
                                <td data-label="Volume">
                                    <span class="i-badge badge--danger">
                                        Low
                                    </span>
                                </td>
                                <td data-label="Outcome">
                                    <span class="i-badge badge--success">
                                        Win
                                    </span>
                                </td>
                                <td data-label="Status">
                                    <span class="i-badge badge--success">
                                        Complete
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td data-label="Initiated At">
                                    2024-09-23 11:46 PM
                                </td>
                                <td data-label="Crypto">
                                    Bitcoin
                                </td>
                                <td data-label="Price">
                                    $63229
                                </td>
                                <td data-label="Amount">
                                    <span class="text--primary">$0.1</span>
                                </td>
                                <td data-label="Arrival Time">
                                    2024-09-23 11:47 PM
                                </td>
                                <td data-label="Volume">
                                    <span class="i-badge badge--danger">
                                        Low
                                    </span>
                                </td>
                                <td data-label="Outcome">
                                    <span class="i-badge badge--info">
                                        Draw
                                    </span>
                                </td>
                                <td data-label="Status">
                                    <span class="i-badge badge--success">
                                        Complete
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td data-label="Initiated At">
                                    2024-09-23 11:44 PM
                                </td>
                                <td data-label="Crypto">
                                    Bitcoin
                                </td>
                                <td data-label="Price">
                                    $63343
                                </td>
                                <td data-label="Amount">
                                    $0.8
                                    +
                                    $0.03
                                    =
                                    <span class="text--success">
                                        $0.83
                                    </span>
                                </td>
                                <td data-label="Arrival Time">
                                    2024-09-23 11:45 PM
                                </td>
                                <td data-label="Volume">
                                    <span class="i-badge badge--danger">
                                        Low
                                    </span>
                                </td>
                                <td data-label="Outcome">
                                    <span class="i-badge badge--success">
                                        Win
                                    </span>
                                </td>
                                <td data-label="Status">
                                    <span class="i-badge badge--success">
                                        Complete
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td data-label="Initiated At">
                                    2024-09-23 06:46 PM
                                </td>
                                <td data-label="Crypto">
                                    Bitcoin
                                </td>
                                <td data-label="Price">
                                    $63390
                                </td>
                                <td data-label="Amount">
                                    <span class="text--primary">$0.8</span>
                                </td>
                                <td data-label="Arrival Time">
                                    2024-09-23 06:47 PM
                                </td>
                                <td data-label="Volume">
                                    <span class="i-badge badge--danger">
                                        Low
                                    </span>
                                </td>
                                <td data-label="Outcome">
                                    <span class="i-badge badge--info">
                                        Draw
                                    </span>
                                </td>
                                <td data-label="Status">
                                    <span class="i-badge badge--success">
                                        Complete
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td data-label="Initiated At">
                                    2024-09-21 07:35 PM
                                </td>
                                <td data-label="Crypto">
                                    Bitcoin
                                </td>
                                <td data-label="Price">
                                    $63102
                                </td>
                                <td data-label="Amount">
                                    $0.77
                                    +
                                    $0.03
                                    =
                                    <span class="text--success">
                                        $0.8
                                    </span>
                                </td>
                                <td data-label="Arrival Time">
                                    2024-09-21 07:36 PM
                                </td>
                                <td data-label="Volume">
                                    <span class="i-badge badge--success">
                                        High
                                    </span>
                                </td>
                                <td data-label="Outcome">
                                    <span class="i-badge badge--success">
                                        Win
                                    </span>
                                </td>
                                <td data-label="Status">
                                    <span class="i-badge badge--success">
                                        Complete
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td data-label="Initiated At">
                                    2024-09-21 01:07 AM
                                </td>
                                <td data-label="Crypto">
                                    Ethereum
                                </td>
                                <td data-label="Price">
                                    $2546.84
                                </td>
                                <td data-label="Amount">
                                    <span class="text--primary">$0.5</span>
                                </td>
                                <td data-label="Arrival Time">
                                    2024-09-21 01:08 AM
                                </td>
                                <td data-label="Volume">
                                    <span class="i-badge badge--danger">
                                        Low
                                    </span>
                                </td>
                                <td data-label="Outcome">
                                    <span class="i-badge badge--info">
                                        Draw
                                    </span>
                                </td>
                                <td data-label="Status">
                                    <span class="i-badge badge--success">
                                        Complete
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td data-label="Initiated At">
                                    2024-09-21 01:05 AM
                                </td>
                                <td data-label="Crypto">
                                    Ethereum
                                </td>
                                <td data-label="Price">
                                    $2544
                                </td>
                                <td data-label="Amount">
                                    $0.6
                                    +
                                    $0.02
                                    =
                                    <span class="text--success">
                                        $0.62
                                    </span>
                                </td>
                                <td data-label="Arrival Time">
                                    2024-09-21 01:06 AM
                                </td>
                                <td data-label="Volume">
                                    <span class="i-badge badge--success">
                                        High
                                    </span>
                                </td>
                                <td data-label="Outcome">
                                    <span class="i-badge badge--success">
                                        Win
                                    </span>
                                </td>
                                <td data-label="Status">
                                    <span class="i-badge badge--success">
                                        Complete
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td data-label="Initiated At">
                                    2024-09-21 12:21 AM
                                </td>
                                <td data-label="Crypto">
                                    Ethereum
                                </td>
                                <td data-label="Price">
                                    $2532.23
                                </td>
                                <td data-label="Amount">
                                    $0.71
                                    +
                                    $0.03
                                    =
                                    <span class="text--success">
                                        $0.74
                                    </span>
                                </td>
                                <td data-label="Arrival Time">
                                    2024-09-21 12:22 AM
                                </td>
                                <td data-label="Volume">
                                    <span class="i-badge badge--success">
                                        High
                                    </span>
                                </td>
                                <td data-label="Outcome">
                                    <span class="i-badge badge--success">
                                        Win
                                    </span>
                                </td>
                                <td data-label="Status">
                                    <span class="i-badge badge--success">
                                        Complete
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td data-label="Initiated At">
                                    2024-09-21 12:17 AM
                                </td>
                                <td data-label="Crypto">
                                    Ethereum
                                </td>
                                <td data-label="Price">
                                    $2532.23
                                </td>
                                <td data-label="Amount">
                                    <span class="text--primary">$0.7</span>
                                </td>
                                <td data-label="Arrival Time">
                                    2024-09-21 12:18 AM
                                </td>
                                <td data-label="Volume">
                                    <span class="i-badge badge--success">
                                        High
                                    </span>
                                </td>
                                <td data-label="Outcome">
                                    <span class="i-badge badge--info">
                                        Draw
                                    </span>
                                </td>
                                <td data-label="Status">
                                    <span class="i-badge badge--success">
                                        Complete
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td data-label="Initiated At">
                                    2024-09-20 08:52 PM
                                </td>
                                <td data-label="Crypto">
                                    Bitcoin
                                </td>
                                <td data-label="Price">
                                    $63253
                                </td>
                                <td data-label="Amount">
                                    $0.69
                                    +
                                    $0.03
                                    =
                                    <span class="text--success">
                                        $0.72
                                    </span>
                                </td>
                                <td data-label="Arrival Time">
                                    2024-09-20 08:53 PM
                                </td>
                                <td data-label="Volume">
                                    <span class="i-badge badge--success">
                                        High
                                    </span>
                                </td>
                                <td data-label="Outcome">
                                    <span class="i-badge badge--success">
                                        Win
                                    </span>
                                </td>
                                <td data-label="Status">
                                    <span class="i-badge badge--success">
                                        Complete
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td data-label="Initiated At">
                                    2024-09-20 08:50 PM
                                </td>
                                <td data-label="Crypto">
                                    Bitcoin
                                </td>
                                <td data-label="Price">
                                    $63253
                                </td>
                                <td data-label="Amount">
                                    <span class="text--primary">$0.69</span>
                                </td>
                                <td data-label="Arrival Time">
                                    2024-09-20 08:51 PM
                                </td>
                                <td data-label="Volume">
                                    <span class="i-badge badge--danger">
                                        Low
                                    </span>
                                </td>
                                <td data-label="Outcome">
                                    <span class="i-badge badge--info">
                                        Draw
                                    </span>
                                </td>
                                <td data-label="Status">
                                    <span class="i-badge badge--success">
                                        Complete
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    <nav class="d-flex justify-items-center justify-content-between">
                        <div class="d-flex justify-content-between flex-fill d-sm-none">
                            <ul class="pagination">

                                <li class="page-item">
                                    <a class="page-link" href="logs-4.html?page=1" rel="prev">&laquo;
                                        Previous</a>
                                </li>


                                <li class="page-item">
                                    <a class="page-link" href="logs-2.html?page=3" rel="next">Next &raquo;</a>
                                </li>
                            </ul>
                        </div>

                        <div
                            class="d-none flex-sm-fill d-sm-flex align-items-sm-center justify-content-sm-between">
                            <div>
                                <p class="small text-muted">
                                    Showing
                                    <span class="fw-semibold">21</span>
                                    to
                                    <span class="fw-semibold">40</span>
                                    of
                                    <span class="fw-semibold">73</span>
                                    results
                                </p>
                            </div>

                            <div>
                                <ul class="pagination">

                                    <li class="page-item">
                                        <a class="page-link" href="logs-4.html?page=1" rel="prev"
                                            aria-label="&laquo; Previous">&lsaquo;</a>
                                    </li>





                                    <li class="page-item"><a class="page-link" href="logs-4.html?page=1">1</a>
                                    </li>
                                    <li class="page-item active" aria-current="page"><span
                                            class="page-link">2</span></li>
                                    <li class="page-item"><a class="page-link" href="logs-2.html?page=3">3</a>
                                    </li>
                                    <li class="page-item"><a class="page-link" href="logs-3.html?page=4">4</a>
                                    </li>


                                    <li class="page-item">
                                        <a class="page-link" href="logs-2.html?page=3" rel="next"
                                            aria-label="Next &raquo;">&rsaquo;</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

@script
<script>
    "use strict";

    $(document).ready(function () {
        const amount = ["0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "200", "433", "10", "10", "10", "10", "0", "10", "5", "10", "10", "0", "1", "10", "20", "0.6", "20", "0", "10", "4", "0", "0", "0", "0.65", "0.2", "0.7", "3", "0.8", "0.8", "0.1", "0", "1", "0.1", "0.5", "0", "0.5", "0.5", "1", "0", "0", "1", "1", "0", "0", "0.68", "0.1", "0.6", "0.04", "0.01", "0", "0.01", "0.01", "0", "0", "0", "0", "0", "0.01", "0", "0", "0", "0", "0"];
        const days = ["2024-07-31", "2024-08-01", "2024-08-02", "2024-08-03", "2024-08-04", "2024-08-05", "2024-08-06", "2024-08-07", "2024-08-08", "2024-08-09", "2024-08-10", "2024-08-11", "2024-08-12", "2024-08-13", "2024-08-14", "2024-08-15", "2024-08-16", "2024-08-17", "2024-08-18", "2024-08-19", "2024-08-20", "2024-08-21", "2024-08-22", "2024-08-23", "2024-08-24", "2024-08-25", "2024-08-26", "2024-08-27", "2024-08-28", "2024-08-29", "2024-08-30", "2024-08-31", "2024-09-01", "2024-09-02", "2024-09-03", "2024-09-04", "2024-09-05", "2024-09-06", "2024-09-07", "2024-09-08", "2024-09-09", "2024-09-10", "2024-09-11", "2024-09-12", "2024-09-13", "2024-09-14", "2024-09-15", "2024-09-16", "2024-09-17", "2024-09-18", "2024-09-19", "2024-09-20", "2024-09-21", "2024-09-22", "2024-09-23", "2024-09-24", "2024-09-25", "2024-09-26", "2024-09-27", "2024-09-28", "2024-09-29", "2024-09-30", "2024-10-01", "2024-10-02", "2024-10-03", "2024-10-04", "2024-10-05", "2024-10-06", "2024-10-07", "2024-10-08", "2024-10-09", "2024-10-10", "2024-10-11", "2024-10-12", "2024-10-13", "2024-10-14", "2024-10-15", "2024-10-16", "2024-10-17", "2024-10-18", "2024-10-19", "2024-10-20", "2024-10-21", "2024-10-22", "2024-10-23", "2024-10-24", "2024-10-25", "2024-10-26", "2024-10-27", "2024-10-28"];
        const currency = "$";
        const content = "Trade Reports Over the Last 90 Days";
        const tradeContent = "Trade Amount";

        const options = {
            series: [{
                name: tradeContent,
                data: amount
            }],
            chart: {
                type: 'bar',
                height: 535,
                toolbar: false,
                foreColor: '#ffffff'
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '50%',
                    endingShape: 'rounded'
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            xaxis: {
                categories: days,
                labels: {
                    style: {
                        colors: '#ffffff'
                    }
                }
            },
            yaxis: {
                title: {
                    text: content,
                    style: {
                        color: '#ffffff'
                    }
                },
                labels: {
                    style: {
                        colors: '#ffffff'
                    }
                }
            },
            fill: {
                opacity: 1
            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return currency + val;
                    },
                    style: {
                        color: '#ffffff'
                    }
                }
            }
        };
        const chart = new ApexCharts(document.querySelector("#totalTrade"), options);
        chart.render();
    });

</script>
@endscript