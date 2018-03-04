import {Card} from "./card";

class Word extends React.Component {
    constructor() {
        super();
        this.state = {
            found: false
        }
    }

    checkWord(e, word) {
        let currentInput = e.target.value;

        this.setState((prevState, props) => {
            return {
                found: currentInput === word,
            }
        });
    }

    render() {
        return (
            <span className="word-check">
                    <input
                        onKeyUp={(e) => this.checkWord(e, this.props.word)}
                        type="text"
                        className={this.state.found ? 'word-found' : '' }
                    />
            </span>
        )
    }
}

export class Question extends React.Component {

    renderMaskedQuestion() {

        return (
            <div>
                {this.props.questionSplit ? this.props.questionSplit
                    .filter(function (part) {
                        return part.hidden;
                    })
                    .map(function (part, i) {
                        return (
                            <Word  key={i} word={part.string}/>
                        )
                    }
                ) : null}
            </div>
        )
    }

    render() {

        return (
            <div className="w-100">
                {this.props.showResults ? <Card content={this.props.question}/> :
                    <Card content={this.props.questionMasked}/>}
                {this.renderMaskedQuestion()}
            </div>
        )
    }
}