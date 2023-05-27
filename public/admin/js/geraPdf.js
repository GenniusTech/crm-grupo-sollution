function criarFichaAssociativa() {

    const nome = document.getElementById('cliente').value;
    const cpf = document.getElementById('cpfcnpj').value;
    const cidade = document.getElementById('cidade').value;

    if(nome == '' || cpf == '' || cidade == ''){
        Swal.fire(
            'Preencha os dados!',
            'Para gerar uma ficha associativa é necessário: Nome, CPF e Endereço!',
            'warning'
        )
    }else{
        const dataAtual = new Date();
        const dia = dataAtual.getDate();
        const mes = obterNomeMes(dataAtual.getMonth() + 1);
        const ano = dataAtual.getFullYear();

        function obterNomeMes(mes) {
            const meses = [
            'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho',
            'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'
            ];
            return meses[mes - 1];
        }

        const doc = new jsPDF();

        doc.setFont('times', 'roman');
        doc.setFontSize(12);

        doc.text(`Nome: ${nome}`, 20, 40);
        doc.line(20, 42, 120, 42);

        doc.text(`CPF: ${cpf}`, 20, 50);
        doc.line(20, 52, 120, 52);

        doc.setFont('times', 'bold');
        doc.text('FICHA DE INSCRIÇÃO ASSOCIATIVA / DECLARAÇÃO / AUTORIZAÇÃO', doc.internal.pageSize.getWidth() / 2, 65, { align: 'center' });

        doc.setFont('times', 'roman');
        doc.setFontSize(12);

        const text = `        Por meio da presente, venho requerer a minha inscrição como associado (a), desta associação. Ao assinar este instrumento, declaro estar ciente do inteiro teor do estatuto social da Associação, bem como dos direitos e deveres impostos aos membros desta instituição. Declaro que consinto com a propositura de Ação de Obrigação de Fazer com Pedido de Tutela de Urgência e Indenização por Danos Morais, para defesa de direito difuso ou coletivo, em meu nome, movida por esta associação.`;

        const paragraphs = text.split('\n');
        const lineHeight = 7;
        const maxLinesPerPage = Math.floor((doc.internal.pageSize.getHeight() - 80) / lineHeight);

        let currentLine = 0;
        let currentPage = 1;

        for (let i = 0; i < paragraphs.length; i++) {
            const lines = doc.splitTextToSize(paragraphs[i], doc.internal.pageSize.getWidth() - 40);
            const numLines = lines.length;

            if (currentLine + numLines > maxLinesPerPage) {
            doc.addPage();
            currentPage++;
            currentLine = 0;
            }

            const startY = 80 + currentLine * lineHeight;
            doc.text(lines, 20, startY);

            currentLine += numLines;
        }

        const linhaData = `${cidade}, ${dia} De ${mes} 20${ano}`;
        const startY = 80 + currentLine * lineHeight;
        doc.text(linhaData, 20, startY);
        doc.text('Assinatura ___________________________________________', 20, startY + lineHeight * 2);

        doc.save(`Ficha Associativa ${nome}.pdf`);
    }
}
