<div class="row">
    <div class="col-lg-12">
        <div class="i-card-sm">
            <div class="card-header">
                <h4 class="title">Latest Transactions</h4>
            </div>
            <div class="filter-area">
                <form action="/users/transactions">
                    <div class="row row-cols-lg-4 row-cols-md-4 row-cols-sm-2 row-cols-1 g-3">
                        <div class="col">
                            <input type="text" name="search" placeholder="Trx ID" value="" />
                        </div>
                        <div class="col">
                            <select class="select2-js" name="wallet_type">
                                <option value="1">PRIMARY</option>
                                <option value="2">INVESTMENT</option>
                                <option value="3">TRADE</option>
                            </select>
                        </div>
                        <div class="col">
                            <select class="select2-js" name="source">
                                <option value="1">ALL</option>
                                <option value="2">MATRIX</option>
                                <option value="3">INVESTMENT</option>
                                <option value="4">TRADE</option>
                            </select>
                        </div>
                        <div class="col">
                            <input
                                type="text"
                                id="date"
                                class="form-control datepicker-here"
                                name="date"
                                value=""
                                data-range="true"
                                data-multiple-dates-separator=" - "
                                data-language="en"
                                data-position="bottom right"
                                autocomplete="off"
                                placeholder="Date"
                            />
                        </div>
                        <div class="col">
                            <button type="submit" class="i-btn btn--lg btn--primary w-100"><i class="bi bi-search me-3"></i>Search</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="card-body">
                <div class="row align-items-center gy-4 mb-3">
                    <div class="table-container">
                        <table id="myTable" class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Initiated At</th>
                                    <th scope="col">Trx</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Post Balance</th>
                                    <th scope="col">Charge</th>
                                    <th scope="col">Source</th>
                                    <th scope="col">Wallet</th>
                                    <th scope="col">Details</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td data-label="Initiated At">2024-10-28 02:16 AM</td>
                                    <td data-label="Trx">3XA9ZWFZGV7A</td>
                                    <td data-label="Amount">
                                        <span class="text--danger">
                                            $100
                                        </span>
                                    </td>
                                    <td data-label="Post Balance">Primary Balance : $18</td>
                                    <td data-label="Charge">$0</td>
                                    <td data-label="Source">
                                        <span class="i-badge badge--success">
                                            Investment
                                        </span>
                                    </td>
                                    <td data-label="Wallet">
                                        <span class="i-badge badge--primary">
                                            Primary Wallet
                                        </span>
                                    </td>
                                    <td data-label="Details">
                                        $100 staking invested for a duration of 10 days
                                    </td>
                                </tr>
                                <tr>
                                    <td data-label="Initiated At">2024-10-27 10:35 PM</td>
                                    <td data-label="Trx">6GAMX3GFRVJS</td>
                                    <td data-label="Amount">
                                        <span class="text--danger">
                                            $10
                                        </span>
                                    </td>
                                    <td data-label="Post Balance">Primary Balance : $118</td>
                                    <td data-label="Charge">$0</td>
                                    <td data-label="Source">
                                        <span class="i-badge badge--primary">
                                            All
                                        </span>
                                    </td>
                                    <td data-label="Wallet">
                                        <span class="i-badge badge--primary">
                                            Primary Wallet
                                        </span>
                                    </td>
                                    <td data-label="Details">
                                        Generate an E-pin worth $10
                                    </td>
                                </tr>
                                <tr>
                                    <td data-label="Initiated At">2024-10-27 09:47 PM</td>
                                    <td data-label="Trx">MB4TKTWGCK6A</td>
                                    <td data-label="Amount">
                                        <span class="text--danger">
                                            $100
                                        </span>
                                    </td>
                                    <td data-label="Post Balance">Investment Balance : $3351.95</td>
                                    <td data-label="Charge">$0</td>
                                    <td data-label="Source">
                                        <span class="i-badge badge--primary">
                                            All
                                        </span>
                                    </td>
                                    <td data-label="Wallet">
                                        <span class="i-badge badge--success">
                                            Investment Wallet
                                        </span>
                                    </td>
                                    <td data-label="Details">
                                        Reduced Investment Balance by $100 added to primary account
                                    </td>
                                </tr>
                                <tr>
                                    <td data-label="Initiated At">2024-10-27 09:47 PM</td>
                                    <td data-label="Trx">Q5E9SY82K76K</td>
                                    <td data-label="Amount">
                                        <span class="text--success">
                                            $100
                                        </span>
                                    </td>
                                    <td data-label="Post Balance">Primary Balance : $128</td>
                                    <td data-label="Charge">$0</td>
                                    <td data-label="Source">
                                        <span class="i-badge badge--primary">
                                            All
                                        </span>
                                    </td>
                                    <td data-label="Wallet">
                                        <span class="i-badge badge--primary">
                                            Primary Wallet
                                        </span>
                                    </td>
                                    <td data-label="Details">
                                        $100 was added to the primary balance from the Investment Balance
                                    </td>
                                </tr>
                                <tr>
                                    <td data-label="Initiated At">2024-10-27 09:46 PM</td>
                                    <td data-label="Trx">34N2YMRRCQZJ</td>
                                    <td data-label="Amount">
                                        <span class="text--danger">
                                            $10
                                        </span>
                                    </td>
                                    <td data-label="Post Balance">Investment Balance : $3451.95</td>
                                    <td data-label="Charge">$0</td>
                                    <td data-label="Source">
                                        <span class="i-badge badge--primary">
                                            All
                                        </span>
                                    </td>
                                    <td data-label="Wallet">
                                        <span class="i-badge badge--success">
                                            Investment Wallet
                                        </span>
                                    </td>
                                    <td data-label="Details">
                                        Reduced Investment Balance by $10 added to primary account
                                    </td>
                                </tr>
                                <tr>
                                    <td data-label="Initiated At">2024-10-27 09:46 PM</td>
                                    <td data-label="Trx">61AVTHNEK78F</td>
                                    <td data-label="Amount">
                                        <span class="text--success">
                                            $10
                                        </span>
                                    </td>
                                    <td data-label="Post Balance">Primary Balance : $28</td>
                                    <td data-label="Charge">$0</td>
                                    <td data-label="Source">
                                        <span class="i-badge badge--primary">
                                            All
                                        </span>
                                    </td>
                                    <td data-label="Wallet">
                                        <span class="i-badge badge--primary">
                                            Primary Wallet
                                        </span>
                                    </td>
                                    <td data-label="Details">
                                        $10 was added to the primary balance from the Investment Balance
                                    </td>
                                </tr>
                                <tr>
                                    <td data-label="Initiated At">2024-10-27 09:12 PM</td>
                                    <td data-label="Trx">FTG3B2666N74</td>
                                    <td data-label="Amount">
                                        <span class="text--danger">
                                            $20
                                        </span>
                                    </td>
                                    <td data-label="Post Balance">Primary Balance : $18</td>
                                    <td data-label="Charge">$1.4</td>
                                    <td data-label="Source">
                                        <span class="i-badge badge--primary">
                                            All
                                        </span>
                                    </td>
                                    <td data-label="Wallet">
                                        <span class="i-badge badge--primary">
                                            Primary Wallet
                                        </span>
                                    </td>
                                    <td data-label="Details">
                                        Withdraw 18.6 via Crypto
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>