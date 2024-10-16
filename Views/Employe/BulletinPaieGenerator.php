<?php
class BulletinPaieGenerator {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function genererBulletinPaie($paiementId) {
        $paiement = $this->getPaiementById($paiementId);
        $employe = $this->getEmployeById($paiement['user_id']);
        
        // Calculs supplémentaires
        $salaireBase = $paiement['salaire_brut'];
        $cotisationSante = $salaireBase * 0.006;
        $cotisationAccidentTravail = $salaireBase * 0.008;
        $cotisationAssuranceVieillesse = $salaireBase * 0.032;
        $impotSurRevenu = $salaireBase * 0.035;
        $totalCotisations = $cotisationSante + $cotisationAccidentTravail + $cotisationAssuranceVieillesse + $impotSurRevenu;
        $salaireNet = $salaireBase - $totalCotisations;

        $html = '
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <title>Bulletin de paie</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    margin: 0;
                    padding: 0;
                    background-color: #fff;
                }
                .container {
                    width: 1000px;
                    margin: 20px auto;
                    border: 1px solid #ccc;
                    padding: 20px;
                }
                .header {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                }
                .header img {
                    width: 100px;
                }
                .header div {
                    text-align: center;
                }
                .header div h1 {
                    margin: 0;
                    color: #00bfa5;
                }
                .info {
                    display: flex;
                    justify-content: space-between;
                    margin-top: 20px;
                }
                .info div {
                    width: 48%;
                }
                .info div p {
                    margin: 5px 0;
                }
                .table-container {
                    margin-top: 20px;
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                }
                table, th, td {
                    border: 1px solid #ccc;
                    height: 15px;
                }
                th, td {
                    padding: 10px;
                    text-align: left;
                    height: 15px;
                }
                th {
                    background-color: #00bfa5;
                    color: #fff;
                }
                .total {
                    text-align: right;
                    padding: 10px;
                    background-color: #00bfa5;
                    color: #fff;
                    font-size: 20px;
                }
                .content-container {
                    display: flex;
                    margin-top: 20px;
                }
                .calendar {
                    margin-left: 20px;
                    border: 1px solid #ccc;
                    padding: 10px;
                    width: 300px;
                }
                .calendar h2 {
                    text-align: center;
                    background-color: #00bfa5;
                    color: #fff;
                    margin: 0;
                    padding: 10px;
                }
                .calendar table {
                    width: 100%;
                    border-collapse: collapse;
                    height: 500px;
                }
                .calendar th, .calendar td {
                    border: 1px solid #ccc;
                    padding: 5px;
                    text-align: center;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="header">
                    <img src="/La_reussite_academy-main/assets/img/logo.png" alt="Logo de l\'académie"/>
                    <div>
                        <h1>Bulletin de paie</h1>
                    </div>
                </div>
                <div class="info">
                    <div>
                        <p>La reussite academy</p>
                        <p>Senegal Dakar</p>
                        <p>Sacré coeur III</p>
                        <p>Numéro de Bulletin : ' . date('Y') . '-' . str_pad($paiement['id'], 3, '0', STR_PAD_LEFT) . '</p>
                    </div>
                    <div>
                        <p>Début de Période: ' . date('01 F Y', strtotime($paiement['mois'])) . '</p>
                        <p>Fin de Période: ' . date('t F Y', strtotime($paiement['mois'])) . '</p>
                        <p>Début du Contrat: ' . $employe['date_embauche'] . '</p>
                        <p>' . $employe['nom'] . ' ' . $employe['prenom'] . '</p>
                        <p>Matricule: ' . $employe['matricule'] . '</p>
                        <p>' . $employe['email'] . '</p>
                        <p>' . $employe['adresse'] . '</p>
                    </div>
                </div>
                <div class="content-container">
                    <div class="table-container">
                        <table>
                            <tr>
                                <th>Classification</th>
                                <th>Salarié</th>
                                <th>Salaire de base, heure, mensuel, taux horaire</th>
                                <th>Rénumération Totale du mois</th>
                            </tr>
                            <tr>
                                <td>Catégorie</td>
                                <td>' . $paiement['nom_role'] . '</td>
                                <td>' . $salaireBase . ' 35h ' . number_format($salaireBase / 35, 2) . '/h</td>
                                <td>' . $paiement['montant'] . '</td>
                            </tr>
                            <tr>
                                <td>Emploi</td>
                                <td>' . $paiement['nom_role'] . '</td>
                                <td></td>
                                <td></td>
                            </tr>
                        </table>

                        <table><br><br><br>
                            <tr>
                                <th>Designations</th>
                                <th>Base</th>
                                <th>Taux Salarial</th>
                                <th>Cotisation Salariales</th>
                            </tr>
                            <tr>
                                <td>SALAIRE DE BASE</td>
                                <td>' . $salaireBase . '</td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>SALAIRE BRUTE</td>
                                <td>' . $salaireBase . '</td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>SANTÉ</td>
                                <td>' . $salaireBase . '</td>
                                <td>0.6%</td>
                                <td>' . number_format($cotisationSante, 2) . '</td>
                            </tr>
                            <tr>
                                <td>ACCIDENT DE TRAVAIL</td>
                                <td>' . $salaireBase . '</td>
                                <td>0.8%</td>
                                <td>' . number_format($cotisationAccidentTravail, 2) . '</td>
                            </tr>
                            <tr>
                                <td>ASSURANCE VIEILLESSE</td>
                                <td>' . $salaireBase . '</td>
                                <td>3.2%</td>
                                <td>' . number_format($cotisationAssuranceVieillesse, 2) . '</td>
                            </tr>
                            <tr>
                                <td>ASSURANCE CHOMAGE</td>
                                <td>' . $salaireBase . '</td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>IMPOT SUR REVENUE</td>
                                <td>' . $salaireBase . '</td>
                                <td>3.5%</td>
                                <td>' . number_format($impotSurRevenu, 2) . '</td>
                            </tr>
                        </table>
                        <br><br>
                        <div class="total">
                            SALAIRE À PAYER AU SALARIÉ: ' . number_format($salaireNet, 2) . '
                        </div>
                    </div>
                    <div class="calendar">
                        <h2>CALENDRIER</h2>
                        <table>
                            <tr>
                                <th>JOUR</th>
                                <th>INCIDENT</th>
                            </tr>';

        // Générer le calendrier
        $joursSemaine = ['D', 'L', 'M', 'M', 'J', 'V', 'S'];
        $premierJour = date('w', strtotime($paiement['mois'] . '-01'));
        $nombreJours = date('t', strtotime($paiement['mois']));

        for ($i = 1; $i <= $nombreJours; $i++) {
            $jourSemaine = $joursSemaine[date('w', strtotime($paiement['mois'] . '-' . $i))];
            $html .= "<tr><td>$jourSemaine</td><td>$i</td></tr>";
        }

        $html .= '
                        </table>
                    </div>
                </div>
            </div>
        </body>
        </html>';

        return $html;
    }

    private function getPaiementById($id) {
        $stmt = $this->pdo->prepare("SELECT p.*, u.nom_role FROM paiement_personnels p JOIN users u ON p.user_id = u.id WHERE p.id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    private function getEmployeById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>