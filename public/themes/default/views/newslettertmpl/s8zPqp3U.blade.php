@extends('layout.mail')
@section('content')
<table class="body">
        <tbody><tr>
            <td class="center" align="center" valign="top">
        <center>

          <table class="row header">
            <tbody><tr>
              <td class="center" align="center">
                <center>

                  <table class="container">
                    <tbody><tr>
                      <td class="wrapper last">

                        <table class="twelve columns">
                          <tbody><tr>
                            <td class="six sub-columns">
                              <img src="http://placehold.it/200x50">
                            </td>
                            <td class="six sub-columns last" style="text-align:right; vertical-align:middle;">
                              <span class="template-label">BASIC</span>
                            </td>
                            <td class="expander"></td>
                          </tr>
                        </tbody></table>

                      </td>
                    </tr>
                  </tbody></table>

                </center>
              </td>
            </tr>
          </tbody></table>

          <table class="container">
            <tbody><tr>
              <td>

                <table class="row">
                  <tbody><tr>
                    <td class="wrapper last">

                      <table class="twelve columns">
                        <tbody><tr>
                          <td>
                            <h1>Hi, {{ $rec['firstname'].' '.$rec['lastname'] }}</h1>
                                        <p class="lead">Phasellus dictum sapien a neque luctus cursus. Pellentesque sem dolor, fringilla et pharetra vitae.</p>
                                        <p>Phasellus dictum sapien a neque luctus cursus. Pellentesque sem dolor, fringilla et pharetra vitae. consequat vel lacus. Sed iaculis pulvinar ligula, ornare fringilla ante viverra et. In hac habitasse platea dictumst. Donec vel orci mi, eu congue justo. Integer eget odio est, eget malesuada lorem. Aenean sed tellus dui, vitae viverra risus. Nullam massa sapien, pulvinar eleifend fringilla id, convallis eget nisi. Mauris a sagittis dui. Pellentesque non lacinia mi. Fusce sit amet libero sit amet erat venenatis sollicitudin vitae vel eros. Cras nunc sapien, interdum sit amet porttitor ut, congue quis urna.</p>
                          </td>
                          <td class="expander"></td>
                        </tr>
                      </tbody></table>

                    </td>
                  </tr>
                </tbody></table>

                <table class="row callout">
                  <tbody><tr>
                    <td class="wrapper last">

                      <table class="twelve columns">
                        <tbody><tr>
                          <td class="panel">
                            <p>Phasellus dictum sapien a neque luctus cursus. Pellentesque sem dolor, fringilla et pharetra vitae. <a href="#">Click it! »</a></p>
                          </td>
                          <td class="expander"></td>
                        </tr>
                      </tbody></table>

                    </td>
                  </tr>
                </tbody></table>

                <table class="row footer">
                  <tbody><tr>
                    <td class="wrapper">

                      <table class="six columns">
                        <tbody><tr>
                          <td class="left-text-pad">

                            <h5>Connect With Us:</h5>

                            <table class="tiny-button facebook">
                              <tbody><tr>
                                <td>
                                  <a href="#">Facebook</a>
                                </td>
                              </tr>
                            </tbody></table>

                            <br>

                            <table class="tiny-button twitter">
                              <tbody><tr>
                                <td>
                                  <a href="#">Twitter</a>
                                </td>
                              </tr>
                            </tbody></table>

                            <br>

                            <table class="tiny-button google-plus">
                              <tbody><tr>
                                <td>
                                  <a href="#">Google +</a>
                                </td>
                              </tr>
                            </tbody></table>

                          </td>
                          <td class="expander"></td>
                        </tr>
                      </tbody></table>

                    </td>
                    <td class="wrapper last">

                      <table class="six columns">
                        <tbody><tr>
                          <td class="last right-text-pad">
                            <h5>Contact Info:</h5>
                            <p>Phone: 408.341.0600</p>
                            <p>Email: <a href="mailto:hseldon@trantor.com">hseldon@trantor.com</a></p>
                          </td>
                          <td class="expander"></td>
                        </tr>
                      </tbody></table>

                    </td>
                  </tr>
                </tbody></table>


                <table class="row">
                  <tbody><tr>
                    <td class="wrapper last">

                      <table class="twelve columns">
                        <tbody><tr>
                          <td align="center">
                            <center>
                              <p style="text-align:center;"><a href="#">Terms</a> | <a href="#">Privacy</a> | <a href="#">Unsubscribe</a></p>
                            </center>
                          </td>
                          <td class="expander"></td>
                        </tr>
                      </tbody></table>

                    </td>
                  </tr>
                </tbody></table>

              <!-- container end below -->
              </td>
            </tr>
          </tbody></table>

        </center>
            </td>
        </tr>
    </tbody></table>
@stop